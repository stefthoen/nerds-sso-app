<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/dashboard/clients', function(Request $request) {
    return view('clients', [
        'clients' => $request->user()->clients
    ]);
})->middleware(['auth', 'verified'])
    ->name('clients');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
