<?php

namespace DeSmart\PasswordReset\Action;

use DeSmart\PasswordReset\Handler\InitPasswordResetHandlerInterface;
use DeSmart\PasswordReset\Validator\InitPasswordResetValidatorInterface;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class InitPasswordResetAction extends Controller
{
    use ValidatesRequests;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var InitPasswordResetValidatorInterface
     */
    protected $validator;

    /**
     * @var InitPasswordResetHandlerInterface
     */
    protected $handler;

    public function __construct(
        Request $request,
        InitPasswordResetValidatorInterface $validator,
        InitPasswordResetHandlerInterface $handler
    )
    {
        $this->request = $request;
        $this->validator = $validator;
        $this->handler = $handler;
    }

    public function execute()
    {
        $this->validateRequest();

        $email = $this->request->get('email');

        $this->validator->validate($email);
        $this->handler->handle($email);

        return new Response('', 204);
    }

    protected function validateRequest()
    {
        $this->validate($this->request, [
            'email' => 'required|email',
        ]);
    }
}
