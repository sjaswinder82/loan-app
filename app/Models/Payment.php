<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'payment_due_at',
        'amount',
        'paid_at',
    ];

    /**
     * Get the loan that owns the Payment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class, 'loan_id', 'id');
    }

    public function getStatusAttribute() 
    {
        if($this->paid_at) {
            return config('app.payment_status.paid');
        } else if(!$this->paid_at && ($this->payment_due_at< Carbon::now())) {
            return config('app.payment_status.due');
        }

        return 'PENDING';
    }
}
