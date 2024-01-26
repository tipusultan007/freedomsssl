<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SpecialInstallment extends Model
{
  use HasFactory;

  protected $fillable = [
    'account_no',
    'user_id',
    'special_dps_id',
    'collector_id',
    'special_dps_loan_id',
    'dps_amount',
    'dps_balance',
    'receipt_no',
    'late_fee',
    'loan_late_fee',
    'other_fee',
    'loan_other_fee',
    'dps_installments',
    'loan_installments',
    'grace',
    'loan_grace',
    'advance',
    'loan_installment',
    'interest',
    'trx_id',
    'loan_balance',
    'total',
    'due',
    'due_return',
    'due_interest',
    'unpaid_interest',
    'advance_return',
    'date',
    'dps_note',
    'loan_note',
    'deposited_via',
    'deposited_via_details',
    'is_sms_sent',
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

  public function dps()
  {
    return $this->belongsTo(SpecialDps::class);
  }

  public function collector()
  {
    return $this->belongsTo(User::class, 'collector_id');
  }

  public function dpsLoan()
  {
    return $this->belongsTo(SpecialDpsLoan::class);
  }

  public function dpsCollections()
  {
    return $this->hasMany(SpecialDpsCollection::class);
  }

  public function loanCollection()
  {
    return $this->hasOne(SpecialLoanCollection::class);
  }

  public function transactions()
  {
    return $this->morphMany(Transaction::class, 'transactionable');
  }
  protected static function boot()
  {
    parent::boot();

    static::created(function ($installment) {

      Transaction::create([
        'account_no' => $installment->account_no,
        'user_id' => $installment->user_id,
        'amount' => $installment->total,
        'type' => 'cashin',
        'transactionable_id' => $installment->id,
        'transactionable_type' => SpecialInstallment::class,
        'date' => $installment->date,
        'manager_id' => Auth::id()
      ]);
    });

    static::deleting(function ($installment) {
      $installment->transactions()->delete();
    });

    /*static::updated(function ($installment) {
      $transaction = Transaction::where('transactionable_id', $installment->id)
        ->where('transactionable_type', SpecialInstallment::class)
        ->first();

      if ($transaction) {
        $transaction->update([
          'amount' => $installment->total,
          'manager_id' => Auth::id(),
          'date' => $installment->date
        ]);
      }
    });*/
  }
}
