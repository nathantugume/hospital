<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Pharmacy Supply Chain Service — integrates with NMS (Uganda), KEMSA (Kenya), MSD (Tanzania).
 *
 * Workflow:
 *   1. placeOrder($provider, $items) — submit a purchase order to the supply chain
 *   2. checkOrderStatus($orderId) — poll order status
 *   3. syncCatalog($provider) — pull updated product catalog
 */
class PharmacySupplyChainService
{
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Place an order with NMS / KEMSA / MSD.
     *
     * @param string $provider One of: nms, kemsa, msd
     * @param array $items [['medicine_code' => '...', 'quantity' => 100], ...]
     */
    public function placeOrder(string $provider, array $items, ?int $purchaseOrderId = null): array
    {
        $config = config("services.{$provider}") ?? $this->config;
        $apiUrl = $config['api_url'] ?? null;
        $apiKey = $config['api_key'] ?? null;

        if (! $apiUrl || ! $apiKey || str_starts_with($apiKey, 'xxx')) {
            return [
                'status' => 'mocked',
                'order_id' => 'SC-' . str_pad((string) ($purchaseOrderId ?? rand(1000, 9999)), 6, '0', STR_PAD_LEFT),
                '_note' => "Set " . strtoupper($provider) . "_API_KEY in .env to enable real integration.",
                'items' => $items,
            ];
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->post("{$apiUrl}/orders", [
                'account_number' => $config['account_number'] ?? null,
                'items' => $items,
                'reference' => $purchaseOrderId,
            ]);

            return [
                'status' => $response->successful() ? 'submitted' : 'failed',
                'status_code' => $response->status(),
                'response' => $response->json(),
            ];

        } catch (\Throwable $e) {
            Log::error('Pharmacy supply chain order failed', [
                'provider' => $provider,
                'error' => $e->getMessage(),
            ]);
            return ['status' => 'failed', 'error' => $e->getMessage()];
        }
    }

    /**
     * API endpoint wrapper used by the controller.
     */
    public function placeOrderApi(string $provider, array $items, ?int $purchaseOrderId = null): array
    {
        return $this->placeOrder($provider, $items, $purchaseOrderId);
    }

    /**
     * Check order status.
     */
    public function checkOrderStatus(string $provider, string $orderId): array
    {
        $config = config("services.{$provider}") ?? $this->config;
        $apiUrl = $config['api_url'] ?? null;
        $apiKey = $config['api_key'] ?? null;

        if (! $apiUrl || ! $apiKey || str_starts_with($apiKey, 'xxx')) {
            return [
                'status' => 'processing',
                'order_id' => $orderId,
                '_mock' => true,
            ];
        }

        $response = Http::withHeaders(['Authorization' => 'Bearer ' . $apiKey])
            ->get("{$apiUrl}/orders/{$orderId}");

        return $response->json() ?? ['status' => 'unknown'];
    }
}
