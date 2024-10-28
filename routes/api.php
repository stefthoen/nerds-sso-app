<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('/logout', function (Request $request) {
    $request->user()->currentAccessToken()->delete();
})->middleware('auth:api');
