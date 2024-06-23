<?php

use Illuminate\Support\Facades\Route;

Route::get('/dashboard/{any}', function () {
    return view('dashboard');
});

Route::get('/auth/{any}', function () {
    return view('auth');
});

Route::get('/{any}', function () {
    return view('app');
})->where('any', '^(?!dashboard|api|auth).*$');
