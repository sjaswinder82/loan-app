<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Loan\ApplyLoanRequest;
use App\Repositories\Contracts\LoanRepository;
use App\Repositories\LoanRepositoryImpl;
use App\Services\LoanService;
use App\Services\PaymentService;
use App\Transformers\LoanTransformer;
use Exception;
use Illuminate\Http\Request;

class LoanController extends ApiController
{
    /**
     * @var LoanService
     */
    private $loanService;

    /**
     * @var PaymentService
     */
    private $paymentService;

    /**
     * @var LoanRepositoryImpl
     */
    private $loanRepository;
    /**
     * load dependencies
     *
     * @param LoanService $loanService
     * @param PaymentService $paymentService
     */
    public function __construct(LoanService $loanService, 
        PaymentService $paymentService,
        LoanRepository $loanRepository)
    {
        $this->paymentService = $paymentService;
        $this->loanService = $loanService;
        $this->loanRepository = $loanRepository;
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

            # create loan
            $loan = $this->loanService->create($params);
            
            # create loan repayment details 
            $this->paymentService->createPaymentPlan($loan, $params);
            $message = trans('messages.loans.request_success');
            return $this->respondCreated($loan, new LoanTransformer, 'loan', 'Loan request accepted.');
        } catch(Exception $e) {
            return $this->respondError($e->getMessage());
        }
    }

    /**
     * handle request to get the payment
     *
     * @return JsonResponse
     */
    public function index(Request $request) 
    {
        try {
            $params =  $this->getLoanListingRequestPayload($request);             
            $loans = $this->loanRepository->getLoans($params);
            return $this->respondCollection($loans, new LoanTransformer, 'loan');
        } catch(Exception $e) {
            return $this->respondError($e->getMessage());
        }
    }

    /**
     * handle request to get loan by uuid
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Request $request, $identifier)
    {
        try {
            $params =  $this->getShowLoanRequestPayload($request, $identifier);             
            $loan = $this->loanRepository->getLoan($params);
            return $this->respondItem($loan, new LoanTransformer, 'loan');
        } catch(Exception $e) {
            return $this->respondError($e->getMessage());
        }
    }


    /**
     * get payload to list loans
     *
     * @param Request $request
     * @return array
     */
    private function getLoanListingRequestPayload($request)
    {
        return [
            'limit' => $request->input('limit') ?? config('app.pagination_limit'),
            'filter' => [
                'user_id' => auth()->user()->id,
            ]
        ];
    }

    /**
     * get payload to show loan
     *
     * @param Request $request
     * @return array
     */
    private function getShowLoanRequestPayload($request, $loanId)
    {
        return [
            'filter' => [
                'user_id' => auth()->user()->id,
                'loan_identifier' => $loanId
            ]
        ];
    }
}
