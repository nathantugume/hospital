<?php

namespace App\Http\Controllers\Api\Integrations;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * MobileMoneyController — MTN MoMo / Airtel Money / M-Pesa
 * Delegates to the corresponding Service class; logs all interactions.
 */
class MobileMoneyController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return $this->success(['service' => 'MobileMoneyController'], 'MTN MoMo / Airtel Money / M-Pesa service is ready.');
    }
}
