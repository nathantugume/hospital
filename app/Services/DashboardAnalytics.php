<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Staff;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\DB;

class DashboardAnalytics
{
    public function forPeriod(CarbonInterface $from, CarbonInterface $to): array
    {
        $appointments = Appointment::whereDate('date', '>=', $from->toDateString())
            ->whereDate('date', '<=', $to->toDateString());
        $payments = Invoice::where('status', 'Paid')
            ->whereDate('payment_date', '>=', $from->toDateString())
            ->whereDate('payment_date', '<=', $to->toDateString());

        $demographics = collect([[0, 17], [18, 34], [35, 49], [50, 64], [65, null]])
            ->map(function (array $ages): array {
                [$minimum, $maximum] = $ages;
                $counts = Patient::query()->where(function ($query) use ($minimum, $maximum): void {
                    $query->where(function ($birthDate) use ($minimum, $maximum): void {
                        $birthDate->whereDate('date_of_birth', '<=', today()->subYears($minimum));
                        if ($maximum !== null) {
                            $birthDate->whereDate('date_of_birth', '>', today()->subYears($maximum + 1));
                        }
                    })->orWhere(function ($storedAge) use ($minimum, $maximum): void {
                        $storedAge->whereNull('date_of_birth')->where('age', '>=', $minimum);
                        if ($maximum !== null) {
                            $storedAge->where('age', '<=', $maximum);
                        }
                    });
                })->select('gender')->selectRaw('COUNT(*) AS total')->groupBy('gender')->pluck('total', 'gender');

                return [
                    'label' => $maximum === null ? "$minimum+" : "$minimum-$maximum",
                    'male' => (int) $counts->get('Male', 0),
                    'female' => (int) $counts->get('Female', 0),
                    'other' => (int) $counts->except(['Male', 'Female'])->sum(),
                ];
            });

        $feedback = DB::table('patient_feedback')->whereDate('date', '>=', $from->toDateString())
            ->whereDate('date', '<=', $to->toDateString())
            ->select('category')->selectRaw('AVG(rating) AS rating, COUNT(*) AS responses')
            ->groupBy('category')->orderBy('category')->get();

        $reviews = DB::table('staff_reviews')->whereDate('review_date', '>=', $from->toDateString())
            ->whereDate('review_date', '<=', $to->toDateString())
            ->whereNotNull('rating')->select('staff_id')->selectRaw('AVG(rating) AS rating, COUNT(*) AS reviews')
            ->groupBy('staff_id')->orderByDesc('rating')->limit(5)->get();
        $staff = Staff::whereIn('id', $reviews->pluck('staff_id'))->get()->keyBy('id');

        return [
            'periodRevenue' => (float) (clone $payments)->sum('paid_amount'),
            'periodAppointments' => (clone $appointments)->count(),
            'demographics' => $demographics,
            'appointmentTypes' => (clone $appointments)->select('type')->selectRaw('COUNT(*) AS total')
                ->groupBy('type')->orderByDesc('total')->get()->map(fn ($row) => ['label' => $row->type ?: 'Unspecified', 'value' => (int) $row->total]),
            'revenueSources' => (clone $payments)->select('payment_method')->selectRaw('SUM(paid_amount) AS total')
                ->groupBy('payment_method')->orderByDesc('total')->get()->map(fn ($row) => ['label' => $row->payment_method ?: 'Unspecified', 'value' => (float) $row->total]),
            'satisfaction' => $feedback,
            'staffPerformance' => $reviews->filter(fn ($review) => $staff->has($review->staff_id))
                ->map(fn ($review) => ['name' => $staff[$review->staff_id]->full_name, 'rating' => (float) $review->rating, 'reviews' => $review->reviews])->values(),
        ];
    }
}
