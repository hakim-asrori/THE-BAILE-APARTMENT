<?php

use Illuminate\Support\Facades\Route;

Route::get('sign', function () {
    return view('auth');
});

Route::get('home/{any?}/{id?}', function () {
    return view('dashboard');
});


Route::get('/{any}', function () {
    return view('app');
})->where('any', '^(?!home|api|sign).*$');
