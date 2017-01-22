<?php

namespace DeSmart\PasswordReset\Handler;

interface InitPasswordResetHandlerInterface
{
    public function handle(string $email);
}
