<?php

namespace DeSmart\PasswordReset\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Model
     */
    private $user;

    /**
     * @var string
     */
    private $resetLink;

    public function __construct(Model $user, string $resetLink)
    {
        $this->user = $user;
        $this->resetLink = $resetLink;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('password-reset::password_reset_init', [
            'reset_link' => $this->resetLink,
            'user' => $this->user,
        ]);
    }
}
