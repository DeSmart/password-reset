<?php

namespace DeSmart\PasswordReset\Handler;

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\Eloquent\Model;

class SetNewPasswordHandler implements SetNewPasswordHandlerInterface
{

    /**
     * @var Hasher
     */
    protected $hasher;

    /**
     * @var Model
     */
    protected $userQuery;

    /**
     * @var Model
     */
    protected $passwordResetQuery;

    public function __construct(Hasher $hasher, Model $userQuery, Model $passwordResetQuery)
    {
        $this->hasher = $hasher;
        $this->userQuery = $userQuery;
        $this->passwordResetQuery = $passwordResetQuery;
    }

    public function handle($userId, string $password)
    {
        $user = $this->userQuery->find($userId);
        $user->password = $this->hasher->make($password);
        $user->save();

        $this->passwordResetQuery->where('email', $user->email)
            ->delete();
    }
}
