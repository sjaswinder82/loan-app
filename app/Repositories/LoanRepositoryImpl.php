<?php

namespace App\Repositories;

use App\Models\Loan;
use App\Repositories\Contracts\LoanRepository;

class LoanRepositoryImpl extends AbstractRepository implements LoanRepository
{   
    /**
     * load dependencies
     *
     * @param Loan $loan
     */
    public function __construct(Loan $loan)
    {
        $this->setModel($loan);
    }

    /**
     * create new loan
     *
     * @param array $payload
     * @return Loan
     */
    public function createLoan(array $payload)
    {
        return $this->create($payload);
    }
}