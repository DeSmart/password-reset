<?php

namespace DeSmart\PasswordReset\Exception;

class PasswordResetTokenNotFoundException extends \Exception
{
    protected $code = 404;
}
