<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Staff;
use App\Models\StaffAvailability;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AppointmentSchedulingService
{
    /**
     * Reject an overlapping active appointment for the same clinician.
     *
     * Callers create and update through this service so the availability
     * check and write share one database transaction.
     */
    public function assertDoctorAvailable(array $attributes, ?int $exceptAppointmentId = null): void
    {
        if (empty($attributes['doctor_id'])) {
            return;
        }

        $start = Carbon::parse($attributes['date'].' '.$attributes['start_time']);
        $end = $start->copy()->addMinutes($attributes['duration_minutes']);
        $endTime = $end->format('H:i:s');

        Staff::query()
            ->where('company_id', $attributes['company_id'])
            ->whereKey($attributes['doctor_id'])
            ->lockForUpdate()
            ->firstOrFail();

        $onLeave = DB::table('staff_leaves')
            ->where('staff_id', $attributes['doctor_id'])
            ->where('status', 'Approved')
            ->whereDate('start_date', '<=', $attributes['date'])
            ->whereDate('end_date', '>=', $attributes['date'])
            ->exists();

        if ($onLeave) {
            throw ValidationException::withMessages([
                'start_time' => 'This doctor has approved time off on the selected date.',
            ]);
        }

        $this->assertWithinConfiguredAvailability($attributes, $endTime);

        $candidates = Appointment::query()
            ->where('company_id', $attributes['company_id'])
            ->where('doctor_id', $attributes['doctor_id'])
            ->whereDate('date', $attributes['date'])
            ->whereNotIn('status', ['Cancelled', 'No-Show'])
            ->when($exceptAppointmentId, fn ($query) => $query->whereKeyNot($exceptAppointmentId))
            ->lockForUpdate()
            ->get();

        $conflict = $candidates->contains(function (Appointment $appointment) use ($start, $end): bool {
            $candidateStart = Carbon::parse($appointment->date->toDateString().' '.$appointment->start_time);
            $minutes = (int) $appointment->duration;
            $minutes = $minutes > 0 ? $minutes : 30;
            $candidateEnd = $appointment->end_time
                ? Carbon::parse($appointment->date->toDateString().' '.$appointment->end_time)
                : $candidateStart->copy()->addMinutes($minutes ?: 30);

            return $candidateStart->lt($end) && $candidateEnd->gt($start);
        });

        if ($conflict) {
            throw ValidationException::withMessages([
                'start_time' => 'This doctor already has an active appointment during the selected time.',
            ]);
        }
    }

    private function assertWithinConfiguredAvailability(array $attributes, string $endTime): void
    {
        $availability = StaffAvailability::query()->where('staff_id', $attributes['doctor_id']);

        if (! (clone $availability)->exists()) {
            return;
        }

        $dayOfWeek = Carbon::parse($attributes['date'])->dayOfWeek;
        $hasDateSpecificSchedule = (clone $availability)->whereDate('date', $attributes['date'])->exists();
        $relevantAvailability = (clone $availability)->when(
            $hasDateSpecificSchedule,
            fn ($query) => $query->whereDate('date', $attributes['date']),
            fn ($query) => $query->whereNull('date')->where('day_of_week', $dayOfWeek),
        );
        $blocked = (clone $relevantAvailability)
            ->where('is_available', false)
            ->where('start_time', '<', $endTime)
            ->where('end_time', '>', $attributes['start_time'])
            ->exists();

        if ($blocked) {
            throw ValidationException::withMessages([
                'start_time' => 'This doctor is unavailable during the selected time.',
            ]);
        }

        $matchesSlot = $relevantAvailability
            ->where('is_available', true)
            ->where('start_time', '<=', $attributes['start_time'])
            ->where('end_time', '>=', $endTime)
            ->exists();

        if (! $matchesSlot) {
            throw ValidationException::withMessages([
                'start_time' => 'The selected time is outside this doctor\'s configured availability.',
            ]);
        }
    }

    public function attributes(array $validated, ?int $companyId): array
    {
        $duration = (int) $validated['duration_minutes'];
        $start = Carbon::parse($validated['date'].' '.$validated['start_time']);

        return [
            'company_id' => $companyId,
            'patient_id' => $validated['patient_id'],
            'doctor_id' => $validated['doctor_id'] ?? null,
            'department_id' => $validated['department_id'] ?? null,
            'service_id' => $validated['service_id'] ?? null,
            'date' => $validated['date'],
            'start_time' => $start->format('H:i:s'),
            'end_time' => $start->copy()->addMinutes($duration)->format('H:i:s'),
            'time_label' => $start->format('g:i A'),
            'duration' => $duration.' min',
            'type' => $validated['type'],
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
            'duration_minutes' => $duration,
        ];
    }
}
