<?php

namespace DeSmart\PasswordReset\Exception;

class PasswordTooShortException extends \Exception
{
    protected $code = 403;
}
