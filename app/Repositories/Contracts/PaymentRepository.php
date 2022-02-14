<?php

namespace App\Repositories\Contracts;

interface PaymentRepository
{
    public function createPayment(array $params);
}