<?php

namespace App\Http\Controllers\Api\Integrations;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * InsuranceIntegrationController — Insurance provider APIs
 * Delegates to the corresponding Service class; logs all interactions.
 */
class InsuranceIntegrationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return $this->success(['service' => 'InsuranceIntegrationController'], 'Insurance provider APIs service is ready.');
    }
}
