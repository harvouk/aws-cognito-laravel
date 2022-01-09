<?php

use App\Http\Controllers\Auth\AwsCognitoController;

Route::get('/login', function(Request $request) {
    return view('auth.login', ['errors' => array()]);
})->name('login');

Route::post('/login', [AwsCognitoController::class, 'login'])->name('login');


Route::get('/register', function(Request $request) {
    return view('auth.login', ['errors' => array()]);
})->name('register');
