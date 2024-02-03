<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialLoanInterest extends Model
{
    use HasFactory;

    protected $fillable = [
        'special_loan_taken_id',
        'account_no',
        'installments',
        'special_installment_id',
        'interest',
        'total',
        'month',
        'year',
        'date',
        'status',
        'is_completed',
        'special_dps_complete_id',

    ];

  public function installment()
  {
    return $this->belongsTo(SpecialInstallment::class);
  }
}
