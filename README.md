# Laravel Password Reset
Password reset mechanism for Laravel. The package provides endpoints and logic for a simple and easy way to 
allow your app's users reset their passwords.

---

### Installation

Install package using Composer:
```
composer require desmart/password-reset
```

Register the package's service provider in `config/app.php`:
```
'providers' => [
        (...)
        DeSmart\PasswordReset\ServiceProvider::class,
    ],
```

Run the Artisan's `vendor:publish` command:

```
php artisan vendor:publish
```

This will copy the `password-reset.php` config file and the `password_reset_init.blade.php` email template into
proper directories, allowing you the tweak them.

Run DB migrations:

```
php artisan migrate
```

The provided migration will drop the current `password_resets` table (if present) and create a new one.

---

### Configuration
In order for the package to send emails to users, Laravel's mailer has to be configured. In order to do this, fill
out these values in the `.env` file:

```
MAIL_DRIVER=<DRIVER>            # e.g. smtp
MAIL_HOST=<HOST>                # e.g. smtp.gmail.com
MAIL_PORT=<PORT>                # e.g. 587
MAIL_USERNAME=<USERNAME>        # e.g. mailer@foobar.com
MAIL_PASSWORD=<PASSWORD>
MAIL_ENCRYPTION=<ENCRYPTION>    # e.g. tls
MAIL_FROM_EMAIL=<EMAIL>         # e.g. mailer@foobar.com
MAIL_FROM_NAME=<FROM>           # MyCompany
```

You have to make some changes in `config/mail.php` (as the file has some hardcoded defaults):
```
'from' => [
    'address' => env('MAIL_FROM_EMAIL', 'hello@example.com'),
    'name' => env('MAIL_FROM_NAME', 'Example'),
],
```

That's it, we're ready to go :)

---

### Usage
The package provides three routes for handling password resets:
- `POST /api/users/password-reset`
- `GET /api/users/password-reset`
- `PUT /api/users/password-reset`

As you can see, the URI is the same for all requests - only the verbs are different.

Let's go briefly through these routes.

#### Initiate password reset
Sending a `POST` request will do the following:
- create a password reset token for the user
- send an email, to the user, with a password reset link

An exception will be thrown if the user does not exist.

Fields required for this operation:
- `email`

#### Verify token
*This route is optional but you may want to use it in order to make sure that the user's ID and password reset
token are both valid.*

Sending a `GET` request will do the following:
- check if the given user's ID and password reset token are both valid

An exception will be thrown if:
- user does not exist
- token is not valid

Fields required for this operation:
- `user_id`
- `token`

#### Set new password
Sending a `PUT` request will do the following:
- set a new password for the user (using Laravel's password hasher)
- remove the password reset token, so it can't be used again

An exception will be thrown if:
- user does not exist
- token is not valid
- password is too short (min. 6 characters)
- password confirmation does not match password

Fields required for this operation:
- `user_id`
- `token`
- `password`
- `password_confirmation`

---

### Custom behaviour
You can change nearly everything to suit your needs.

The package assumes you use the default User model. If you want to use a custom model - change in the 
`password-reset.php` config file.

The same file holds the info about the Password Reset model used and the password reset link pattern, sent in
the email to the user.

Should you need to change the validators or handlers - you can always write your **custom service provider** that
binds your classes to appropriate interfaces.

Don't like the routes provided by the package? Create your own service provider, remove the route loading section
and define your own routes.

Change what you want :)

---

### Notice
The package has no unit tests, sorry :( If you can provide any tests - that would be great.
