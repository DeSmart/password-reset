<?php

Route::post('/api/users/password-reset', ['uses' => 'DeSmart\PasswordReset\Action\InitPasswordResetAction@execute']);
Route::put('/api/users/password-reset', ['uses' => 'DeSmart\PasswordReset\Action\SetNewPasswordAction@execute']);
Route::get('/api/users/password-reset', ['uses' => 'DeSmart\PasswordReset\Action\VerifyTokenAction@execute']);
