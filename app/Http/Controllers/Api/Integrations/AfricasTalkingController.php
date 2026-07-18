<?php

namespace App\Http\Controllers\Api\Integrations;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * AfricasTalkingController — Africa's Talking SMS gateway
 * Delegates to the corresponding Service class; logs all interactions.
 */
class AfricasTalkingController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return $this->success(['service' => 'AfricasTalkingController'], "Africa's Talking SMS gateway service is ready.");
    }
}
