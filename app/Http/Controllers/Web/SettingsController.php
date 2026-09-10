<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\CurrencyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function edit(CurrencyService $currency): View
    {
        return view('settings.index', [
            'currency' => $currency,
            'currencies' => $currency->options(),
        ]);
    }

    public function update(Request $request, CurrencyService $currency): RedirectResponse
    {
        $validated = $request->validate([
            'currency' => ['required', 'string', Rule::in(array_keys($currency->options()))],
        ]);

        $currency->setCode($validated['currency']);

        return redirect()
            ->route('admin.settings.edit')
            ->with('status', 'Currency settings updated successfully.');
    }
}
