<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class PaymentTransformer extends TransformerAbstract
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
            'id' => $resource->id,
            'payment_due_date' => $resource->payment_due_at,
            'term_amount' => $resource->amount,
            'paid_date' => $resource->paid_at,
            'status' => $resource->status,
            'loan_id' => $resource->loan->loan_identifier,
        ];
    }
}
