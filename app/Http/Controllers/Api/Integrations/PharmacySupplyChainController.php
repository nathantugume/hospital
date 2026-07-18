<?php

namespace App\Http\Controllers\Api\Integrations;

use App\Http\Controllers\Controller;
use App\Services\PharmacySupplyChainService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PharmacySupplyChainController extends Controller
{
    public function placeOrderApi(Request $request, string $provider, PharmacySupplyChainService $service): JsonResponse
    {
        $data = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.medicine_code' => ['required', 'string', 'max:100'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'purchase_order_id' => ['nullable', 'integer'],
        ]);

        return $this->success(
            $service->placeOrderApi($provider, $data['items'], $data['purchase_order_id'] ?? null),
            'Supply chain order processed.'
        );
    }
}
