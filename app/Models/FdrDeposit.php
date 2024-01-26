<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class FdrDeposit extends Model
{
  use HasFactory;
  use Searchable;

  protected $fillable = [
    'account_no',
    'fdr_id',
    'user_id',
    'amount',
    'fdr_package_id',
    'date',
    'commencement',
    'balance',
    'profit',
    'note',
    'trx_id',
    'deposited_via',
    'deposited_via_details',
    'is_sms_sent',
    'manager_id'
  ];

  protected $searchableFields = ['*'];

  protected $table = 'fdr_deposits';

  public function manager()
  {
    return $this->belongsTo(Manager::class);
  }

  public function fdr()
  {
    return $this->belongsTo(Fdr::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function fdrPackage()
  {
    return $this->belongsTo(FdrPackage::class);
  }

  public function fdrWithdraws()
  {
    return $this->hasMany(FdrWithdraw::class);
  }

  public function profitCollections()
  {
    return $this->hasMany(ProfitCollection::class);
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
        'amount' => $installment->amount,
        'type' => 'cashin',
        'transactionable_id' => $installment->id,
        'transactionable_type' => FdrDeposit::class,
        'date' => $installment->date,
        'manager_id' => Auth::id()
      ]);
    });

    static::deleting(function ($installment) {
      $installment->transactions()->delete();
    });

    static::updated(function ($installment) {
      $transaction = Transaction::where('transactionable_id', $installment->id)
        ->where('transactionable_type', FdrDeposit::class)
        ->first();

      if ($transaction) {
        $transaction->update([
          'amount' => $installment->amount,
          'date' => $installment->date,
          'manager_id' => Auth::id()
        ]);
      }
    });
  }
}
