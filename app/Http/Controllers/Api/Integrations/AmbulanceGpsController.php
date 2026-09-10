<?php

namespace App\Http\Controllers\Api\Integrations;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * AmbulanceGpsController — Ambulance GPS tracking
 * Delegates to the corresponding Service class; logs all interactions.
 */
class AmbulanceGpsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return $this->success(['service' => 'AmbulanceGpsController'], 'Ambulance GPS tracking service is ready.');
    }
}
