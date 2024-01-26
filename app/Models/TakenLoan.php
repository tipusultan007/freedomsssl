<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class TakenLoan extends Model
{
  use HasFactory;
  use Searchable;
  use SoftDeletes;

  protected $fillable = [
    'account_no',
    'user_id',
    'loan_amount',
    'remain',
    'before_loan',
    'after_loan',
    'interest1',
    'interest2',
    'upto_amount',
    'date',
    'commencement',
    'created_by',
    'dps_loan_id',
    'approved_by',
    'installment',
    'note',
    'trx_id',
    'bank_name',
    'branch_name',
    'cheque_no',
    'documents',
    'documents_note',
    'is_sms_sent',
    'manager_id'
  ];

  protected $searchableFields = ['*'];

  protected $table = 'taken_loans';


  public function manager()
  {
    return $this->belongsTo(Manager::class);
  }

  public function interests()
  {
    return $this->hasMany(DpsLoanInterest::class);
  }

  public function payments()
  {
    return $this->hasMany(LoanPayment::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function approvedBy()
  {
    return $this->belongsTo(User::class, 'approved_by');
  }

  public function dpsLoan()
  {
    return $this->belongsTo(DpsLoan::class);
  }

  public function allLoanDocuments()
  {
    return $this->hasMany(LoanDocuments::class);
  }

  public function guarantor()
  {
    return $this->hasOne(Guarantor::class);
  }
  public function transactions()
  {
    return $this->morphMany(Transaction::class, 'transactionable');
  }
  protected static function boot()
  {
    parent::boot();

    static::created(function ($loan) {
      // Create a new Transaction record
      Transaction::create([
        'account_no' => $loan->account_no,
        'user_id' => $loan->user_id,
        'amount' => $loan->loan_amount,
        'type' => 'cashout',
        'transactionable_id' => $loan->id,
        'transactionable_type' => TakenLoan::class,
        'date' => $loan->date,
        'manager_id' => Auth::id()
      ]);
    });

    static::updated(function ($loan) {
      $transaction = Transaction::where('transactionable_id', $loan->id)
        ->where('transactionable_type', TakenLoan::class)
        ->first();

      if ($transaction) {
        $transaction->update([
          'amount' => $loan->loan_amount,
          'manager_id' => Auth::id(),
          'date' => $loan->date
        ]);
      }
    });

    // Define the deleting event callback
    static::deleting(function ($loan) {
      $loan->transactions()->delete();
    });
  }
}
