<?php

namespace DeSmart\PasswordReset\Handler;

use DeSmart\PasswordReset\Mail\PasswordResetMail;
use Illuminate\Mail\Mailer;
use Illuminate\Database\Eloquent\Model;

class InitPasswordResetHandler implements InitPasswordResetHandlerInterface
{

    /**
     * @var Model
     */
    protected $userQuery;

    /**
     * @var Model
     */
    protected $passwordResetQuery;

    /**
     * @var string
     */
    protected $linkPattern;

    /**
     * @var string
     */
    protected $appUrl;

    /**
     * @var Mailer
     */
    protected $mailer;

    public function __construct(
        Model $userQuery,
        Model $passwordResetQuery,
        string $linkPattern,
        string $appUrl,
        Mailer $mailer
    )
    {
        $this->userQuery = $userQuery;
        $this->passwordResetQuery = $passwordResetQuery;
        $this->linkPattern = $linkPattern;
        $this->appUrl = $appUrl;
        $this->mailer = $mailer;
    }

    public function handle(string $email)
    {
        $user = $this->userQuery->where('email', $email)
            ->first();

        $this->passwordResetQuery->where('email', $email)
            ->delete();

        $token = $this->createTokenForEmail($email);
        $link = $this->getLink($token->token, $user->id);

        $this->mailer->to($email)
            ->send(new PasswordResetMail($user, $link));
    }

    protected function createTokenForEmail(string $email)
    {
        $token = new $this->passwordResetQuery;

        $token->email = $email;
        $token->created_at = new \DateTime;
        $token->token = str_random();

        $token->save();

        return $token;
    }

    protected function getLink(string $token, $userId)
    {
        $link = preg_replace(
            [
                '/{USER_ID}/',
                '/{TOKEN}/'
            ],
            [
                $userId,
                $token
            ],
            $this->linkPattern);

        return $this->appUrl . $link;
    }
}
