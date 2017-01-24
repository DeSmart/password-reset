<?php

namespace DeSmart\PasswordReset\Handler;

interface SetNewPasswordHandlerInterface
{
    public function handle($userId, string $password);
}
