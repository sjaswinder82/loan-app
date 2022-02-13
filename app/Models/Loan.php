<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
