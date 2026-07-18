<?php

namespace App\Http\Controllers\Api\Integrations;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * LisController — Lab Information System
 * Delegates to the corresponding Service class; logs all interactions.
 */
class LisController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return $this->success(['service' => 'LisController'], 'Lab Information System service is ready.');
    }
}
