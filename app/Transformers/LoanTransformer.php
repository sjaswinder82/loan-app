<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class LoanTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($resource)
    {
        return [
            'id' => $resource->loan_identifier,
            'user_id' => $resource->user_id,
            'principal_amount' => (double) $resource->loan_amount,
            'status' => $resource->status,
            'loan_term' => (int) $resource->loan_term,
            'approved_at' => $resource->approval_date,
            'disbursed_at' => $resource->disbursal_date,
            'closed_at' => $resource->closure_date,
        ];
    }
}
