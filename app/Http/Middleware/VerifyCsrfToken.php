<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    protected $except = [
        'api/v1/payments/mtn/callback',
        'api/v1/payments/airtel/callback',
        'api/v1/payments/mpesa/callback',
        'api/v1/integrations/africas-talking/callback',
        'api/v1/integrations/insurance/*/webhook',
        'api/v1/integrations/gps/callback',
    ];
}
