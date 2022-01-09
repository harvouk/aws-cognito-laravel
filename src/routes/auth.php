<?php

use App\Http\Controllers\Auth\AwsCognitoController;

Route::group(['middleware' => ['web']], function () {

    Route::get('/login', [AwsCognitoController::class, 'login_get'])->name('login');
    Route::post('/login', [AwsCognitoController::class, 'login_post'])->name('login');

    Route::get('/register', [AwsCognitoController::class, 'register_get'])->name('register');
    Route::post('/register', [AwsCognitoController::class, 'register_post'])->name('register');

    Route::get('/confirm-signup', [AwsCognitoController::class, 'confirm_signup_get'])->name('confirm_signup');
    Route::post('/confirm-signup', [AwsCognitoController::class, 'confirm_signup_post'])->name('confirm_signup');

    Route::get('/resend-confirmation-code', [AwsCognitoController::class, 'resend_confirmation_code_get'])->name('resend_confirmation_code');
    Route::post('/resend-confirmation-code', [AwsCognitoController::class, 'resend_confirmation_code_post'])->name('resend_confirmation_code');

    Route::get('/forgot-password', [AwsCognitoController::class, 'forgotten_password_get'])->name('forgot_password');
    Route::post('/forgot-password', [AwsCognitoController::class, 'forgotten_password_post'])->name('forgot_password');

    Route::get('/reset-password', [AwsCognitoController::class, 'forgot_password_confirm_get'])->name('forgot_password_confirm');
    Route::post('/reset-password', [AwsCognitoController::class, 'forgot_password_confirm_post'])->name('forgot_password_confirm');

});

Route::group(['middleware' => ['auth']], function () {

    Route::get('/get_devices', [AwsCognitoController::class, 'get_devices'])->name('get_devices');

});
