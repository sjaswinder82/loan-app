<?php

namespace App\Repositories;

use App\Models\Payment;
use App\Repositories\Contracts\PaymentRepository;

class PaymentRepositoryImpl extends AbstractRepository implements PaymentRepository
{   
    /**
     * load dependencies
     *
     * @param Payment $payment
     */
    public function __construct(Payment $payment)
    {
        $this->setModel($payment);
    }

    /**
     * create new Payment
     *
     * @param array $payload
     * @return Payment
     */
    public function createPayment(array $payload)
    {
        return $this->create($payload);
    }

    /**
     * Insert Payments
     *
     * @param array $payload
     * @return Payment
     */
    public function createLoanPayments(array $payload)
    {
        $this->getModel()->insert($payload);
    }
}