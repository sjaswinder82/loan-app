<?php

namespace App\Repositories;

use App\Models\Loan;
use App\Repositories\Contracts\LoanRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

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

    /**
     * get loans
     *
     * @param array $params
     * @return LengthAwarePaginator
     */
    public function getLoans(array $params)
    {
        $filter = Arr::get($params, 'filter', []);
        
        return $this->filter($filter)
                    ->with('payments')
                    ->paginate(Arr::get($params, 'limit'));
    }

    /**
     * get loan
     *
     * @param array $params
     * @return Loan
     */
    public function getLoan(array $params)
    {
        $filter = Arr::get($params, 'filter', []);

        return $this->filter($filter)
                    ->first();
    }

    /**
     * get builder with filter
     *
     * @param array $filter
     * @return Builder
     */
    private function filter(array $filter)
    {
        $builder = $this->getModel();

        if($userId = Arr::get($filter, 'user_id')) {
            $builder = $builder->whereUserId($userId);
        }

        if($uuid = Arr::get($filter, 'loan_identifier')) {
            $builder = $builder->whereLoanIdentifier($uuid);
        }

        return $builder;
    }
}