<?php

namespace DeSmart\PasswordReset\Action;

use DeSmart\PasswordReset\Handler\SetNewPasswordHandlerInterface;
use DeSmart\PasswordReset\Validator\SetNewPasswordValidatorInterface;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

/**
 * Sets a new password for the given user.
 */
class SetNewPasswordAction extends Controller
{
    use ValidatesRequests;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var SetNewPasswordValidatorInterface
     */
    protected $validator;

    /**
     * @var SetNewPasswordHandlerInterface
     */
    protected $handler;

    public function __construct(
        Request $request,
        SetNewPasswordValidatorInterface $validator,
        SetNewPasswordHandlerInterface $handler
    )
    {
        $this->request = $request;
        $this->validator = $validator;
        $this->handler = $handler;
    }

    public function execute()
    {
        $userId = $this->request->get('user_id');
        $password = $this->request->get('password');

        $this->validateRequest();

        $this->validator->validate(
            $userId,
            $this->request->get('token'),
            $password
        );

        $this->handler->handle($userId, $password);

        return new Response('', 204);
    }

    protected function validateRequest()
    {
        $this->validate($this->request, [
            'user_id' => 'required',
            'token' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);
    }
}
