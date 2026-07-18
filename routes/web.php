<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Serves the static frontend (HTML files in public/) with SPA fallback.
| The frontend must look and behave exactly as-is.
*/

// Catch-all: serve the requested static file if it exists, otherwise index.html
Route::get('/{any}', function () {
    $path = public_path(request()->path());
    if (file_exists($path) && is_file($path)) {
        return response()->file($path);
    }
    return response()->file(public_path('index.html'));
})->where('any', '^(?!api|horizon).*$');

// Root → index.html
Route::get('/', function () {
    return response()->file(public_path('index.html'));
});
