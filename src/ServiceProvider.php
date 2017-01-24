<?php

namespace DeSmart\PasswordReset;

use DeSmart\PasswordReset\Handler\InitPasswordResetHandler;
use DeSmart\PasswordReset\Handler\InitPasswordResetHandlerInterface;
use DeSmart\PasswordReset\Validator\InitPasswordResetValidator;
use DeSmart\PasswordReset\Validator\InitPasswordResetValidatorInterface;
use Illuminate\Mail\Mailer;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $config = $this->app->make('config');
        $packageConfig = $config['password-reset'];

        $this->app->bind(InitPasswordResetValidatorInterface::class, function ($app) use ($packageConfig) {
            return new InitPasswordResetValidator(
                new $packageConfig['user_model']
            );
        });

        $this->app->bind(InitPasswordResetHandlerInterface::class, function ($app) use ($packageConfig, $config) {
            return new InitPasswordResetHandler(
                new $packageConfig['user_model'],
                new $packageConfig['password_reset_model'],
                $packageConfig['password_reset_form_url_pattern'],
                $config['app']['url'],
                $app->make(Mailer::class)
            );
        });
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'password-reset');

        $this->publishes([
            __DIR__ . '/../config/password-reset.php' => config_path('password-reset.php'),
            __DIR__.'/../views' => resource_path('views/vendor/password-reset'),
        ]);

        require __DIR__ . '/routes.php';
    }
}
