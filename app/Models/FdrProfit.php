<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class FdrProfit extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'account_no',
        'user_id',
        'fdr_id',
        'profit',
        'balance',
        'date',
        'grace',
        'other_fee',
        'created_by',
        'trx_id',
        'month',
        'year',
        'note',
      'is_sms_sent',
      'manager_id'
    ];

    protected $searchableFields = ['*'];

    protected $table = 'fdr_profits';

    protected $casts = [
        'date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fdr()
    {
        return $this->belongsTo(Fdr::class);
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

    static::created(function ($loan) {
      $total = $loan->profit;
      if ($loan->grace != "")
      {
        $total += $loan->grace;
      }
      if ($loan->other_fee != "")
      {
        $total -= $loan->other_fee;
      }
      // Create a new Transaction record
      Transaction::create([
        'account_no' => $loan->account_no,
        'user_id' => $loan->user_id,
        'amount' => $total,
        'type' => 'cashout',
        'transactionable_id' => $loan->id,
        'transactionable_type' => FdrProfit::class,
        'date' => $loan->date,
        'manager_id' => Auth::id()
      ]);
    });

    static::updated(function ($loan) {
      $transaction = Transaction::where('transactionable_id', $loan->id)
        ->where('transactionable_type', FdrProfit::class)
        ->first();

      $total = $loan->profit;
      if ($loan->grace != "")
      {
        $total += $loan->grace;
      }
      if ($loan->other_fee != "")
      {
        $total -= $loan->other_fee;
      }

      if ($transaction) {
        $transaction->update([
          'amount' => $total,
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
