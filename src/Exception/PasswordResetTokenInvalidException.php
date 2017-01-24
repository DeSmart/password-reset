<?php

namespace DeSmart\PasswordReset\Exception;

class PasswordResetTokenInvalidException extends \Exception
{
    protected $code = 403;
}
