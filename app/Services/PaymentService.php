<?php

namespace App\Services;

use App\Models\Loan;
use App\Repositories\Contracts\PaymentRepository;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class PaymentService
{   
    /**
     * payment repository
     */
    public function __construct(PaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * create payment plan for loan
     *
     * @param array $params [user_id,loan_id, loan_term, loan_amount]
     * @return void
     */
    public function createPaymentPlan(Loan $loan, array $params)
    {
        $paymentTerms = [];

        $loanTerm = Arr::get($params, 'loan_term');
        $interestRate = config('app.loan_interest');
        $amount =  $loan->loan_amount * $interestRate * $loanTerm / 100 * 52; 
        $weeklyAmountToBePaid = $amount/$loanTerm;
        
        # calculate the dates 
        for($i = 1;$i<=$loanTerm;$i++) {
            $paymentTerms[] = [
                'loan_id' => $loan->id,
                # start the date from frist week from approval. Using default approval for now.
                'payment_due_at' => Carbon::now()->addWeek(1),
                'amount' => $weeklyAmountToBePaid,
            ];
        }

        $this->paymentRepository->createLoanPayments($paymentTerms);
    }
}