<?php

namespace App\Services;

use App\Models\Loan;
use App\Repositories\Contracts\LoanRepository;
use Illuminate\Support\Str;

class LoanService
{
    /**
     * loanRepository
     *
     * @var LoanRepository
     */
    private $loanRepository;

    /**
     * create instance
     *
     * @param LoanRepository $loanRepository
     */
    public function __construct(LoanRepository $loanRepository)
    {
        $this->loanRepository = $loanRepository;
    }

    /**
     * create loan
     *
     * @param array $params
     * @return Loan
     */
    public function create(array $params)
    {
        # generate loan uuid
        $params['loan_identifier'] = $this->generateLoanIdentifier();
        
        # set loan status
        # TODO: add endpoint for approval for the loan
        $params['status'] = config('app.loan_status.approved');
    
        return $this->loanRepository->createLoan($params);
    }

    private function generateLoanIdentifier() {
        return Str::uuid();
    }
}