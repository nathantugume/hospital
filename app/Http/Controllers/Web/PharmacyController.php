<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PharmacyController extends Controller
{
    public function index(Request $request): View
    {
        $medicines = Medicine::query()
            ->when($request->string('search')->trim()->value(), function ($query, string $search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('generic_name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            })
            ->when($request->string('stock')->trim()->value() === 'low', fn ($query) => $query->whereColumn('stock', '<=', 'reorder_level'))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        $stats = [
            'catalogue' => Medicine::count(),
            'low_stock' => Medicine::whereColumn('stock', '<=', 'reorder_level')->count(),
            'out_of_stock' => Medicine::where('stock', '<=', 0)->count(),
            'expiring' => Medicine::whereNotNull('expiry')->whereBetween('expiry', [today(), today()->addDays(90)])->count(),
        ];
        $recentPrescriptions = Prescription::with(['patient', 'doctor'])->latest('date')->limit(6)->get();

        return view('pharmacy.index', compact('medicines', 'stats', 'recentPrescriptions'));
    }

    public function alerts(Request $request): View
    {
        $type = $request->string('type')->trim()->value() ?: 'all';

        $stats = [
            'low_stock' => Medicine::whereColumn('stock', '<=', 'reorder_level')->where('stock', '>', 0)->count(),
            'out_of_stock' => Medicine::where('stock', '<=', 0)->count(),
            'expiring' => Medicine::whereNotNull('expiry')->whereBetween('expiry', [today(), today()->addDays(30)])->count(),
            'catalogue' => Medicine::count(),
        ];

        $alerts = Medicine::query()
            ->where(function ($query): void {
                $query->whereColumn('stock', '<=', 'reorder_level')
                    ->orWhereBetween('expiry', [today(), today()->addDays(30)]);
            })
            ->when($type === 'low', fn ($query) => $query->whereColumn('stock', '<=', 'reorder_level')->where('stock', '>', 0))
            ->when($type === 'out', fn ($query) => $query->where('stock', '<=', 0))
            ->when($type === 'expiring', fn ($query) => $query->whereNotNull('expiry')->whereBetween('expiry', [today(), today()->addDays(30)]))
            ->orderBy('stock')
            ->paginate(20)
            ->withQueryString();

        return view('pharmacy.alerts', compact('alerts', 'stats', 'type'));
    }
}
