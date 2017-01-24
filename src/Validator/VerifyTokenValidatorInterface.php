<?php

namespace DeSmart\PasswordReset\Validator;

interface VerifyTokenValidatorInterface
{
    public function validate($userId, string $token);
}
