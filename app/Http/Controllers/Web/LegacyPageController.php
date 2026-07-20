<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class LegacyPageController extends Controller
{
    public function show(string $page): View
    {
        abort_unless(view()->exists("legacy.{$page}"), 404);

        return view('coming-soon', [
            'featureTitle' => ucwords(str_replace(['-', '_'], ' ', $page)),
        ]);
    }
}
