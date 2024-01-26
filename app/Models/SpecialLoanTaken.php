<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class SpecialLoanTaken extends Model
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
    'special_dps_loan_id',
    'installment',
    'approved_by',
    'note',
    'trx_id',
    'is_sms_sent',
    'manager_id'
  ];

  protected $searchableFields = ['*'];

  protected $table = 'special_loan_takens';

  public function manager()
  {
    return $this->belongsTo(Manager::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function approvedBy()
  {
    return $this->belongsTo(User::class, 'approved_by');
  }

  public function specialDpsLoan()
  {
    return $this->belongsTo(SpecialDpsLoan::class);
  }


  public function payments()
  {
    return $this->hasMany(SpecialLoanPayment::class);
  }

  public function interests()
  {
    return $this->hasMany(SpecialLoanInterest::class);
  }

  public function guarantor()
  {
    return $this->hasOne(Guarantor::class, 'special_taken_loan_id', 'id');
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
        'transactionable_type' => SpecialLoanTaken::class,
        'date' => $loan->date,
        'manager_id' => Auth::id()
      ]);
    });

    static::updated(function ($loan) {
      $transaction = Transaction::where('transactionable_id', $loan->id)
        ->where('transactionable_type', SpecialLoanTaken::class)
        ->first();

      if ($transaction) {
        $transaction->update([
          'amount' => $loan->loan_amount,
          'manager_id' => Auth::id(),
          'date'=> $loan->date
        ]);
      }
    });

    // Define the deleting event callback
    static::deleting(function ($loan) {
      $loan->transactions()->delete();
    });
  }
}
