<?php

return [

    /**
     * User model the package should use
     */
    'user_model' => \App\User::class,

    /**
     * Password reset model the package should use
     */
    'password_reset_model' => \DeSmart\PasswordReset\Model\PasswordResetModel::class,

    /**
     * Password reset link sent to the user
     */
    'password_reset_form_url_pattern' => '/users/{USER_ID}/password-reset/{TOKEN}',
];
