<?php

use App\Http\Controllers\Auth\AwsCognitoController;

Route::get('/login', function(Request $request) {
    return view('auth.login', ['errors' => array()]);
})->name('login');

Route::post('/login', [AwsCognitoController::class, 'login'])->name('login');


Route::get('/register', function(Request $request) {
    return view('auth.register', ['errors' => array()]);
})->name('register');

Route::post('/register', [AwsCognitoController::class, 'register'])->name('register');

Route::get('/verify', function(Request $request) {
    return view('auth.verify', ['errors' => array()]);
})->name('verify');

Route::post('/verify', [AwsCognitoController::class, 'verify'])->name('verify');
