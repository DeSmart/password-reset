<?php

namespace DeSmart\PasswordReset\Action;

use DeSmart\PasswordReset\Validator\VerifyTokenValidatorInterface;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

/**
 * Checks if the password reset token matches the given user.
 */
class VerifyTokenAction extends Controller
{
    use ValidatesRequests;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var VerifyTokenValidatorInterface
     */
    protected $validator;

    public function __construct(
        Request $request,
        VerifyTokenValidatorInterface $validator
    ) {
        $this->request = $request;
        $this->validator = $validator;
    }

    public function execute()
    {
        $this->validateRequest();

        $this->validator->validate(
            $this->request->get('user_id'),
            $this->request->get('token')
        );

        return new Response('', 204);
    }

    protected function validateRequest()
    {
        $this->validate($this->request, [
            'user_id' => 'required',
            'token' => 'required',
        ]);
    }
}
