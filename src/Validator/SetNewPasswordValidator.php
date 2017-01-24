<?php

namespace DeSmart\PasswordReset\Validator;

use DeSmart\PasswordReset\Exception\PasswordResetTokenInvalidException;
use DeSmart\PasswordReset\Exception\PasswordResetTokenNotFoundException;
use DeSmart\PasswordReset\Exception\PasswordTooShortException;
use DeSmart\PasswordReset\Exception\UserNotFoundException;
use Illuminate\Database\Eloquent\Model;

class SetNewPasswordValidator implements SetNewPasswordValidatorInterface
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

    public function validate($userId, string $token, string $password)
    {
        $user = $this->userQuery->find($userId);

        if (null === $user) {
            throw new UserNotFoundException;
        }

        $this->validateToken($user, $token);
        $this->validatePassword($password);
    }

    /**
     * @param Model $user
     * @param string $token
     * @throws PasswordResetTokenInvalidException
     * @throws PasswordResetTokenNotFoundException
     */
    protected function validateToken(Model $user, string $token)
    {
        $storedToken = $this->passwordResetQuery->where('email', $user->email)
            ->first();

        if (null === $storedToken) {
            throw new PasswordResetTokenNotFoundException;
        }

        if ($storedToken->token !== $token) {
            throw new PasswordResetTokenInvalidException;
        }
    }

    /**
     * @param string $password
     * @throws PasswordTooShortException
     */
    protected function validatePassword(string $password)
    {
        if (strlen($password) < 6) {
            throw new PasswordTooShortException;
        }
    }
}
