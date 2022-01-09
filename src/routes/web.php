<?php

use Harvouk\AwsCognitoLaravel\AwsCognitoController;

Route::get('/login', function(Request $request) {
    return view('auth.login', ['errors' => array()]);
})->name('login');

Route::post('/login', [AwsCognitoController::class, 'login'])->name('login');
