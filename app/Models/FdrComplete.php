<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class FdrComplete extends Model
{
    use HasFactory;
  use LogsActivity;

  protected $fillable = [
    'fdr_id',
    'account_no',
    'withdraw',
    'profit',
    'remain',
    'service_charge',
    'date',
    'manager_id',
  ];


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

    static::created(function ($dpsComplete) {
      $total = $dpsComplete->withdraw + $dpsComplete->profit;
      // Create a new Transaction record
      Transaction::create([
        'account_no' => $dpsComplete->account_no,
        'user_id' => $dpsComplete->user_id,
        'amount' => $total,
        'type' => 'cashout',
        'transactionable_id' => $dpsComplete->id,
        'transactionable_type' => FdrComplete::class,
        'date' => $dpsComplete->date,
        'manager_id' => $dpsComplete->manager_id
      ]);
    });

    static::updated(function ($dpsComplete) {
      $total = $dpsComplete->withdraw + $dpsComplete->profit;
      $transaction = Transaction::where('transactionable_id', $dpsComplete->id)
        ->where('transactionable_type', FdrComplete::class)
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
      $dpsComplete->transactions()->delete();
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
      'service_charge' => 'ফি',
      'date' => 'তারিখ',
    ];

    // Get the original description
    $description = "";

    switch ($eventName) {
      case 'created':
        $description = "স্থায়ী সঞ্চয় (FDR) উত্তোলন নতুন এন্ট্রি করা হয়েছে";
        break;
      case 'updated':
        $description = "স্থায়ী সঞ্চয় (FDR) উত্তোলন এন্ট্রি আপডেট করা হয়েছে";
        break;
      case 'deleted':
        $description = "স্থায়ী সঞ্চয় (FDR) উত্তোলন থেকে এন্ট্রি ডিলেট করা হয়েছে";
        break;
      default:
        $description = "স্থায়ী সঞ্চয় (FDR) উত্তোলন {$eventName}";
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
