<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class DpsComplete extends Model
{
  use HasFactory;
  use LogsActivity;

  protected $fillable = [
    'dps_id',
    'user_id',
    'dps_loan_id',
    'account_no',
    'withdraw',
    'profit',
    'remain',
    'loan_payment',
    'interest',
    'grace',
    'service_fee',
    'date',
    'manager_id',
  ];


  public function dps()
  {
    return $this->belongsTo(Dps::class);
  }

  public function manager()
  {
    return $this->belongsTo(Manager::class);
  }

  public function transaction()
  {
    return $this->morphOne(Transaction::class, 'transactionable');
  }

  protected static function boot()
  {
    parent::boot();

    static::created(function ($dpsComplete) {
      $cashout = $dpsComplete->withdraw + $dpsComplete->profit;
      $cashIn = $dpsComplete->loan_payment + $dpsComplete->interest - $dpsComplete->grace;
      $total = 0;
      $type = '';
      if ($cashout>$cashIn)
      {
        $total = $cashout - $cashIn;
        $type = 'cashout';
      }else{
        $total = $cashIn - $cashout;
        $type = 'cashin';
      }
      // Create a new Transaction record
      Transaction::create([
        'account_no' => $dpsComplete->account_no,
        'user_id' => $dpsComplete->user_id,
        'amount' => $total,
        'type' => $type,
        'transactionable_id' => $dpsComplete->id,
        'transactionable_type' => DpsComplete::class,
        'date' => $dpsComplete->date,
        'manager_id' => $dpsComplete->manager_id
      ]);
    });

    static::updated(function ($dpsComplete) {
      $total = $dpsComplete->withdraw + $dpsComplete->profit;
      $transaction = Transaction::where('transactionable_id', $dpsComplete->id)
        ->where('transactionable_type', DpsComplete::class)
        ->first();

      if ($transaction) {
        $transaction->update([
          'amount' => $total,
          'manager_id' => $dpsComplete->manager_id,
          'date' => $dpsComplete->date
        ]);
      }
    });

    // Define the deleting event callback
    static::deleting(function ($dpsComplete) {
      $dpsComplete->transaction->delete();
    });
  }

  public function getActivitylogOptions(): LogOptions
  {
    return LogOptions::defaults()->logAll();
  }

  public function getDescriptionForEvent(string $eventName): string
  {
    // Define custom property names based on the event
    $customPropertyNames = [
      'account_no' => 'হিসাব নং',
      'withdraw' => 'উত্তোলন',
      'profit' => 'মুনাফা',
      'remain' => 'অবশিষ্ট জমা',
      'loan_payment' => 'ঋণ পরিশোধ',
      'interest' => 'ঋণের লভ্যাংশ',
      'grace' => 'ঋণ মওকুফ',
      'service_charge' => 'ফি',
      'date' => 'তারিখ',
    ];

    // Get the original description
    $description = "";

    switch ($eventName) {
      case 'created':
        $description = "মাসিক সঞ্চয় (DPS) উত্তোলন নতুন এন্ট্রি করা হয়েছে";
        break;
      case 'updated':
        $description = "মাসিক সঞ্চয় (DPS) উত্তোলন এন্ট্রি আপডেট করা হয়েছে";
        break;
      case 'deleted':
        $description = "মাসিক সঞ্চয় (DPS) উত্তোলন থেকে এন্ট্রি ডিলেট করা হয়েছে";
        break;
      default:
        $description = "মাসিক সঞ্চয় (DPS) উত্তোলন {$eventName}";
    }

    // Add custom property names to the description
    foreach ($customPropertyNames as $property => $propertyName) {

      $value = match ($property) {
        'date' => date('d/m/Y', strtotime($this->$property)),
        default => $this->$property ?? null,
      };

      $description .= " | {$propertyName}: {$value}";
    }
    return $description;
  }
}
