<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'taken_loan_id',
        'account_no',
        'dps_installment_id',
        'amount',
        'balance',
        'date',
        'trx_id'
    ];
}
