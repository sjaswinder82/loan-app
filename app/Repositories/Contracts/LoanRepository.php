<?php

namespace App\Repositories\Contracts;

interface LoanRepository
{
    public function createLoan(array $params);
    public function getLoans(array $params);
}