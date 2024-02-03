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
        'is_completed',
      'special_dps_complete_id',
    ];

    public function installment()
    {
      return $this->belongsTo(SpecialInstallment::class);
    }
}
