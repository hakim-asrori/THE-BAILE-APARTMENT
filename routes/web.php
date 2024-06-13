<?php

use Illuminate\Support\Facades\Route;

Route::get('/{any}', function () {
    return view('app');
})->where('any', '^(?!test).*$');

Route::post('/test', function () {
    return response()->json([
        "code" => 200,
        "status" => "SUCCESS",
        "data" => []
    ]);
});
