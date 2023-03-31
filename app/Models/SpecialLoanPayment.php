<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialLoanPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'special_loan_taken_id',
        'special_installment_id',
        'account_no',
        'amount',
        'balance',
        'date',
        'trx_id'
    ];
}
