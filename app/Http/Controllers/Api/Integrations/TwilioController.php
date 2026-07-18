<?php

namespace App\Http\Controllers\Api\Integrations;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * TwilioController — Twilio emergency voice
 * Delegates to the corresponding Service class; logs all interactions.
 */
class TwilioController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return $this->success(['service' => 'TwilioController'], 'Twilio emergency voice service is ready.');
    }
}
