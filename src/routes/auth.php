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

Route::get('/confirm_signup', function(Request $request) {
    return view('auth.confirm_signup', ['errors' => array()]);
})->name('confirm_signup');

Route::post('/confirm_signup', [AwsCognitoController::class, 'confirm_signup'])->name('confirm_signup');

Route::get('/resend_confirmation_code', function(Request $request) {
    return view('auth.resend_confirmation_code', ['errors' => array()]);
})->name('resend_confirmation_code');

Route::post('/resend_confirmation_code', [AwsCognitoController::class, 'resend_confirmation_code'])->name('resend_confirmation_code');
