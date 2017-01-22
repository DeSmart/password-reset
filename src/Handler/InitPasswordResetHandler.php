<?php

namespace DeSmart\PasswordReset\Handler;

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Mail\Mailer;
//use ComPortal\WebPlugin\Users\Mail\ResetPassword;
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

//    /**
//     * @var Mailer
//     */
//    protected $mailer;
//
//    /**
//     * @var UrlGenerator
//     */
//    protected $urlGenerator;
//
//    /**
//     * @var string
//     */
//    protected $appUrl;

    public function __construct(
        Model $userQuery,
        Model $passwordResetQuery
//        Mailer $mailer,
//        UrlGenerator $urlGenerator,
//        string $appUrl
    ) {
        $this->userQuery = $userQuery;
        $this->passwordResetQuery = $passwordResetQuery;
//        $this->mailer = $mailer;
//        $this->urlGenerator = $urlGenerator;
//        $this->appUrl = $appUrl;
    }

    public function handle(string $email)
    {
        $user = $this->userQuery->where('email', $email)
            ->first();

        $this->passwordResetQuery->where('email', $email)
            ->delete();

        $token = $this->createTokenForEmail($email);

        dd($token);
//        $link = "{$this->appUrl}/login/reset/finish?user_id={$user->getId()}&token={$token->getToken()}";
//
//        $this->mailer->to($email)
//            ->send(new ResetPassword($user, $link));
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
}
