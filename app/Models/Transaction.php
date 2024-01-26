<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
  use HasFactory;

  protected $fillable = [
    'account_id',
    'description',
    'trx_id',
    'date',
    'amount',
    'user_id',
    'account_no',
    'type',
    'name',
    'interest_type',
    'transactionable_id',
    'transactionable_type',
    'manager_id'
  ];

  public function transactionable()
  {
    return $this->morphTo();
  }

  public function manager()
  {
    return $this->belongsTo(Manager::class);
  }

  public function account()
  {
    return $this->belongsTo(Account::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function getTransactionableDisplayNameAttribute()
  {
    switch ($this->transactionable_type) {
      case 'App\Models\SavingsCollection':
        if ($this->type == 'cashin') {
          return 'দৈনিক সঞ্চয় আদায়';
        } else {
          return 'দৈনিক সঞ্চয় উত্তোলন';
        }
      case 'App\Models\DailyLoanCollection':
        return 'দৈনিক ঋণ আদায়';
      case 'App\Models\DpsInstallment':
        return 'মাসিক সঞ্চয়/ঋণ আদায়';
      case 'App\Models\SpecialInstallment':
        return 'বিশেষ (Special) সঞ্চয়/ঋণ আদায়';
      case 'App\Models\DailyLoan':
        return 'দৈনিক ঋণ প্রদান';
      case 'App\Models\TakenLoan':
        return 'মাসিক ঋণ প্রদান';
      case 'App\Models\SpecialLoanTaken':
        return 'বিশেষ ঋণ প্রদান';
      case 'App\Models\FdrDeposit':
        return 'FDR জমা';
      case 'App\Models\FdrWithdraw':
        return 'FDR উত্তোলন';
      case 'App\Models\FdrProfit':
        return 'FDR মুনাফা উত্তোলন';
      case 'App\Models\DailySavingsComplete':
        return 'দৈনিক সঞ্চয় উত্তোলন (নিস্পত্তি)';
      case 'App\Models\DpsComplete':
        return 'মাসিক সঞ্চয় (DPS) উত্তোলন (নিস্পত্তি)';
      case 'App\Models\SpecialDpsComplete':
        return 'বিশেষ সঞ্চয় (Special) উত্তোলন (নিস্পত্তি)';
        case 'App\Models\FdrComplete':
        return 'স্থায়ী সঞ্চয় (FDR) উত্তোলন (নিস্পত্তি)';
      default:
        return $this->transactionable_type;
    }
  }

  public function getTransactionTypeAttribute()
  {
    switch ($this->type) {
      case 'cashin':
        return '<span class="badge rounded-pill bg-label-success">নগদ গ্রহণ</span>';
      case 'cashout':
        return '<span class="badge rounded-pill bg-label-danger">নগদ প্রদান</span>';
      // Add more cases as needed
      default:
        return $this->type;
    }
  }
}
