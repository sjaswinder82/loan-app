<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Loan extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'loan_identifier',
        'loan_amount',
        'status',
        'loan_term',
        'approved_at',
        'disbursed_at',
        'closed_at',
    ];

    /**
     * Get all of the payments for the Loan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'loan_id', 'id');
    }
}
