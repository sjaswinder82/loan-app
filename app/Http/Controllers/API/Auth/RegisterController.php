<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Repositories\Contracts\UserRepository;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;

class RegisterController extends ApiController  
{
    private $userRepository;

    /**
     * load dependencies
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    
    /**
     * handle request to register new user
     *
     * @return void
     */
    public function __invoke(RegisterUserRequest $request)
    {
        $params = $request->only('name', 'email');

        # generate a random password
        $params['password'] = $this->encryptPassword($request);        
        
        # create user
        $user = $this->userRepository->register($params);
        
        $message = trans('messages.register_success');
        return $this->respondCreated($user, new UserTransformer, 'user', $message);
    }

    /**
     * encrypt user input password
     * @param Request $request
     * @return string
     */
    private function encryptPassword($request)
    {
        return bcrypt($request->input('password'));
    }
}
