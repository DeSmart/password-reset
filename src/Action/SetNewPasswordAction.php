<?php

namespace DeSmart\PasswordReset\Action;

use DeSmart\PasswordReset\Validator\SetNewPasswordValidatorInterface;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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

    public function __construct(
        Request $request,
        SetNewPasswordValidatorInterface $validator
    )
    {
        $this->request = $request;
        $this->validator = $validator;
    }

    public function execute()
    {
        $this->validateRequest();

        $this->validator->validate(
            $this->request->get('user_id'),
            $this->request->get('token'),
            $this->request->get('password')
        );
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
