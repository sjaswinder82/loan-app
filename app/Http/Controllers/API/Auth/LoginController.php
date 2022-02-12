<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Repositories\Contracts\UserRepository;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;

class LoginController extends ApiController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * load dependencies
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    
    public function __invoke(LoginRequest $request)
    {
        $credentials = $this->getCredentials($request);

        $token = auth()->attempt($credentials);
        
        if(!$token) {
            return $this->respondError(trans('messages.invalid_credentials'), 422);
        }

        $user = auth()->user();
        $user->access_token = auth()->login($user);

        return $this->respondItem($user,  new UserTransformer, 'user');
    }

    /**
     * get credentials from request
     *
     * @param Request $request
     * @return array
     */
    private function getCredentials($request)
    {
        return $request->only('email', 'password');
    }
    // $user->access_token = auth()->login($user);
    //
}
