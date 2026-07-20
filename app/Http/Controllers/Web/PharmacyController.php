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
}
