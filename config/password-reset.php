<?php

return [
    'user_model' => \App\User::class,
    'password_reset_model' => \DeSmart\PasswordReset\Model\PasswordResetModel::class,
    'password_reset_form_url_pattern' => '/users/{USER_ID}/password-reset/{TOKEN}',
];
