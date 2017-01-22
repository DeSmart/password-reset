<?php

namespace DeSmart\PasswordReset\Validator;

use DeSmart\PasswordReset\Exception\UserNotFoundException;
use Illuminate\Database\Eloquent\Model;

class InitPasswordResetValidator implements InitPasswordResetValidatorInterface
{

    /**
     * @var Model
     */
    private $query;

    public function __construct(Model $query)
    {
        $this->query = $query;
    }

    public function validate(string $email)
    {
        $user = $this->query->where('email', $email)
            ->first();

        if (null === $user) {
            throw new UserNotFoundException;
        }
    }
}
