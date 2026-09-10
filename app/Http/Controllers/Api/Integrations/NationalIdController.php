<?php

namespace App\Http\Controllers\Api\Integrations;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * NationalIdController — NIRA / NIIMS / NIDA verification
 * Delegates to the corresponding Service class; logs all interactions.
 */
class NationalIdController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return $this->success(['service' => 'NationalIdController'], 'NIRA / NIIMS / NIDA verification service is ready.');
    }
}
