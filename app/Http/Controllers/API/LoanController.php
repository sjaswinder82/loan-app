<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Loan\ApplyLoanRequest;
use App\Services\LoanService;
use App\Services\PaymentService;
use App\Transformers\LoanTransformer;
use Exception;

class LoanController extends ApiController
{
    /**
     * load dependencies
     *
     * @param LoanService $loanService
     */
    public function __construct(LoanService $loanService)
    {
        $this->loanService = $loanService;
    }

    /**
     * handle request to create a new loan
     *
     * @param ApplyLoanRequest $request
     * @return JsonResponse
     */
    public function store(ApplyLoanRequest $request)
    {
        try {
            $params = $request->only('loan_amount', 'loan_term');
            $params['user_id'] = auth()->user()->id;

            $loan = $this->loanService->create($params);
            $message = trans('messages.loans.request_success');
            return $this->respondCreated($loan, new LoanTransformer, 'loan', 'Loan request accepted.');
        } catch(Exception $e) {
            return $this->respondError($e->getMessage());
        }
    }
}
