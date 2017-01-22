<?php

namespace DeSmart\PasswordReset;

use DeSmart\PasswordReset\Handler\InitPasswordResetHandler;
use DeSmart\PasswordReset\Handler\InitPasswordResetHandlerInterface;
use DeSmart\PasswordReset\Validator\InitPasswordResetValidator;
use DeSmart\PasswordReset\Validator\InitPasswordResetValidatorInterface;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $config = $this->app->make('config');
        $userModel = $config['password-reset']['user_model'];
        $passwordResetModel = $config['password-reset']['password_reset_model'];

        $this->app->bind(InitPasswordResetValidatorInterface::class, function ($app) use ($userModel) {
            return new InitPasswordResetValidator(
                new $userModel
            );
        });

        $this->app->bind(InitPasswordResetHandlerInterface::class, function ($app) use ($userModel, $passwordResetModel) {
            return new InitPasswordResetHandler(
                new $userModel,
                new $passwordResetModel
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
