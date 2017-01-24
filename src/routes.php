<?php

/**
 * Initializes the password reset procedure.
 */
Route::post('/api/users/password-reset', ['uses' => 'DeSmart\PasswordReset\Action\InitPasswordResetAction@execute']);

/**
 * Sets a new password.
 */
Route::put('/api/users/password-reset', ['uses' => 'DeSmart\PasswordReset\Action\SetNewPasswordAction@execute']);

/**
 * Validates the token against the user.
 */
Route::get('/api/users/password-reset', ['uses' => 'DeSmart\PasswordReset\Action\VerifyTokenAction@execute']);
