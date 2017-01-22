<?php

namespace DeSmart\PasswordReset\Exception;

class UserNotFoundException extends \Exception
{
    protected $code = 404;
}
