<?php

namespace DeSmart\PasswordReset\Validator;

use DeSmart\PasswordReset\Exception\PasswordResetTokenInvalidException;
use DeSmart\PasswordReset\Exception\PasswordResetTokenNotFoundException;
use DeSmart\PasswordReset\Exception\UserNotFoundException;
use Illuminate\Database\Eloquent\Model;

class VerifyTokenValidator implements VerifyTokenValidatorInterface
{

    /**
     * @var Model
     */
    protected $userQuery;

    /**
     * @var Model
     */
    protected $passwordResetQuery;

    public function __construct(Model $userQuery, Model $passwordResetQuery)
    {
        $this->userQuery = $userQuery;
        $this->passwordResetQuery = $passwordResetQuery;
    }

    /**
     * @param $userId
     * @param string $token
     * @throws PasswordResetTokenInvalidException
     * @throws PasswordResetTokenNotFoundException
     * @throws UserNotFoundException
     */
    public function validate($userId, string $token)
    {
        $user = $this->userQuery->find($userId);

        if (null === $user) {
            throw new UserNotFoundException;
        }

        $storedToken = $this->passwordResetQuery->where('email', $user->email)
            ->first();

        if (null === $storedToken) {
            throw new PasswordResetTokenNotFoundException;
        }

        if ($storedToken->token !== $token) {
            throw new PasswordResetTokenInvalidException;
        }
    }
}
