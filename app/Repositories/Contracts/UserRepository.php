<?php

namespace App\Repositories\Contracts;

interface UserRepository
{
    public function register(array $params);
}