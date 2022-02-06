<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepository;

class UserRepositoryImpl extends AbstractRepository implements UserRepository
{   
    /**
     * load dependencies
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->setModel($user);
    }

    /**
     * create new user
     *
     * @param array $payload
     * @return User
     */
    public function register(array $payload)
    {
        return $this->create($payload);
    }
}