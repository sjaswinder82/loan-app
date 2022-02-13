<?php

namespace App\Repositories\Contracts;

interface LoanRepository
{
    public function createLoan(array $params);
}