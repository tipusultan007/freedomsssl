<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialLoanCollection extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_no',
        'user_id',
        'special_dps_loan_id',
        'collector_id',
        'special_installment_id',
        'trx_id',
        'loan_installment',
        'balance',
        'interest',
        'due_interest',
        'unpaid_interest',
        'date',
        'receipt_no',
      'manager_id'
    ];
  public function manager()
  {
    return $this->belongsTo(Manager::class);
  }
  public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dpsLoan()
    {
        return $this->belongsTo(DpsLoan::class);
    }

    public function collector()
    {
        return $this->belongsTo(User::class, 'collector_id');
    }

    public function dpsInstallment()
    {
        return $this->belongsTo(DpsInstallment::class);
    }
}
