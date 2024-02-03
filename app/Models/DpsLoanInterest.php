<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DpsLoanInterest extends Model
{
    use HasFactory;

    protected $fillable = [
        'taken_loan_id',
        'account_no',
        'installments',
        'dps_installment_id',
        'dps_complete_id',
        'interest',
        'total',
        'month',
        'year',
        'date',
        'is_completed',
        'status'
    ];

  public function dpsInstallment()
  {
    return $this->belongsTo(DpsInstallment::class, 'dps_installment_id');
  }

}
