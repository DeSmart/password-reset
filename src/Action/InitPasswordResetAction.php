<?php

namespace DeSmart\PasswordReset\Action;

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

    public function __construct(Request $request, InitPasswordResetValidatorInterface $validator)
    {
        $this->request = $request;
        $this->validator = $validator;
    }

    public function execute()
    {
        $this->validateRequet();

        $this->validator->validate(
            $this->request->get('email')
        );

//        $this->commandBus->handle($command);

        return new Response('', 204);
    }

    protected function validateRequet()
    {
        $this->validate($this->request, [
            'email' => 'required|email',
        ]);
    }
}
