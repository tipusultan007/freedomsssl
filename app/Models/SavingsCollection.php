<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


class SavingsCollection extends Model
{
  use HasFactory;
  use SoftDeletes;
  use LogsActivity;

  const logAttributes = ['account_no',
    'saving_amount',
    'type',
    'late_fee',
    'other_fee',
    'date',
    'balance',
    'total'];

  protected $fillable = [
    'account_no',
    'daily_savings_id',
    'saving_amount',
    'type',
    'late_fee',
    'other_fee',
    'collector_id',
    'date',
    'balance',
    'user_id',
    'trx_id',
    'total',
    'manager_id',
    'collection_date'
  ];

  protected $table = 'savings_collections';
  protected static $logFillable = true;
  public function manager()
  {
    return $this->belongsTo(Manager::class);
  }

  public function transactions()
  {
    return $this->morphMany(Transaction::class, 'transactionable');
  }

  public function dailySavings()
  {
    return $this->belongsTo(DailySavings::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function collector()
  {
    return $this->belongsTo(User::class, 'collector_id');
  }

  protected static function boot()
  {
    parent::boot();

    static::created(function ($savingCollection) {
      // Create a new Transaction record
      Transaction::create([
        'account_no' => $savingCollection->account_no,
        'user_id' => $savingCollection->user_id,
        'amount' => $savingCollection->total,
        'type' => $savingCollection->type == 'deposit'?'cashin':'cashout',
        'transactionable_id' => $savingCollection->id,
        'transactionable_type' => SavingsCollection::class,
        'date' => $savingCollection->date,
        'manager_id' => Auth::id()
      ]);
    });

    // Define the deleting event callback
    static::deleting(function ($savingCollection) {
      // Delete related transactions
      $saving = DailySavings::find($savingCollection->daily_savings_id);
      if ($savingCollection->type == 'deposit') {
        $saving->total -= $savingCollection->saving_amount;
        $saving->deposit -= $savingCollection->saving_amount;
        $saving->balance -= $savingCollection->saving_amount;
      } elseif ($savingCollection->type == 'withdraw') {
        $saving->total += $savingCollection->saving_amount;
        $saving->balance += $savingCollection->saving_amount;
        $saving->withdraw -= $savingCollection->saving_amount;
      }
      $saving->save();
      $savingCollection->transactions()->delete();
    });
  }

  public function calculateAndSetTotal()
  {
    if ($this->type === 'withdraw') {
      $total = $this->saving_amount - ($this->late_fee + $this->other_fee);
    } elseif ($this->type === 'deposit') {
      $total = $this->saving_amount + $this->late_fee + $this->other_fee;
    } else {
      $total = 0;
    }

    $this->total = $total;
  }

  /**
   * @return LogOptions
   */

  public function getActivitylogOptions(): LogOptions
  {
    return LogOptions::defaults()->logOnly(self::logAttributes);
  }
  public function getDescriptionForEvent(string $eventName): string
  {
    // Define custom property names based on the event
    $customPropertyNames = [
      'account_no' => 'হিসাব নং',
      'saving_amount' => 'পরিমাণ',
      'type' => 'ধরণ',
      'date' => 'তারিখ',
    ];

    // Get the original description
    $description = "";

    switch ($eventName) {
      case 'created':
        $description = "দৈনিক সঞ্চয়ে নতুন এন্ট্রি করা হয়েছে";
        break;
      case 'updated':
        $description = "দৈনিক সঞ্চয়ে এন্ট্রি আপডেট করা হয়েছে";
        break;
      case 'deleted':
        $description = "দৈনিক সঞ্চয় থেকে এন্ট্রি ডিলেট করা হয়েছে";
        break;
      default:
        $description = "দৈনিক সঞ্চয় {$eventName}";
    }

    // Add custom property names to the description
    foreach ($customPropertyNames as $property => $propertyName) {

      $value = match ($property) {
        'date' => date('d/m/Y', strtotime($this->$property)),
        'type' => $this->$property == 'deposit' ? 'জমা' : 'উত্তোলন',
        default => $this->$property ?? null,
      };

      $description .= " | {$propertyName}: {$value}";
    }
    return $description;
  }
}
