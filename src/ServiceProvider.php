<?php

namespace DeSmart\PasswordReset;

use DeSmart\PasswordReset\Validator\InitPasswordResetValidator;
use DeSmart\PasswordReset\Validator\InitPasswordResetValidatorInterface;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->app->bind(InitPasswordResetValidatorInterface::class, function ($app) {
            $userModelClassName = config('password-reset.user_model');

            return new InitPasswordResetValidator(
                new $userModelClassName
            );
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/password-reset.php' => config_path('password-reset.php'),
        ]);

        require __DIR__ . '/routes.php';
    }
}
