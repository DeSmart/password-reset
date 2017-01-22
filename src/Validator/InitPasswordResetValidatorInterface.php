<?php

namespace DeSmart\PasswordReset\Validator;

interface InitPasswordResetValidatorInterface
{
    public function validate(string $email);
}
