<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class FdrWithdraw extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'account_no',
        'user_id',
        'fdr_id',
        'date',
        'fdr_deposit_id',
        'amount',
        'note',
        'balance',
        'trx_id',
        'is_sms_sent',
        'manager_id'
    ];

    protected $searchableFields = ['*'];

    protected $table = 'fdr_withdraws';


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fdr()
    {
        return $this->belongsTo(Fdr::class);
    }

    public function fdrDeposit()
    {
        return $this->belongsTo(FdrDeposit::class);
    }

    public function manager()
    {
        return $this->belongsTo(Manager::class);
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
        'type' => 'cashout',
        'transactionable_id' => $installment->id,
        'transactionable_type' => FdrWithdraw::class,
        'date' => $installment->date,
        'manager_id' => Auth::id()
      ]);
    });

    static::deleting(function ($installment) {
      $installment->transactions()->delete();
    });

    static::updated(function ($installment) {
      $transaction = Transaction::where('transactionable_id', $installment->id)
        ->where('transactionable_type', FdrWithdraw::class)
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
