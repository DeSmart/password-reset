<?php

namespace DeSmart\PasswordReset\Validator;

interface SetNewPasswordValidatorInterface
{
    public function validate($userId, string $token, string $password);
}
