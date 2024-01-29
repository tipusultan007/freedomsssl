<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class DailyLoan extends Model
{
  use HasFactory;
  use Searchable;
  use SoftDeletes;
  use LogsActivity;

  protected $fillable = [
    'user_id',
    'daily_savings_id',
    'package_id',
    'account_no',
    'per_installment',
    'opening_date',
    'interest',
    'adjusted_amount',
    'commencement',
    'loan_amount',
    'total',
    'balance',
    'application_date',
    'created_by',
    'approved_by',
    'status',
    'balance',
    'grace',
    'paid_interest',
    'trx_id',
    'is_sms_sent',
    'manager_id'
  ];

  protected $searchableFields = ['*'];

  protected $table = 'daily_loans';

  public function getActivitylogOptions(): LogOptions
  {
    return LogOptions::defaults()->logAll();
  }
  public function getDescriptionForEvent(string $eventName): string
  {
    // Define custom property names based on the event
    $customPropertyNames = [
      'account_no' => 'হিসাব নং',
      'loan_amount' => 'পরিমাণ',
      'id' => 'ঋণ ID',
      'date' => 'তারিখ',
    ];

    // Get the original description
    $description = "";

    switch ($eventName) {
      case 'created':
        $description = "দৈনিক ঋণ প্রদান নতুন এন্ট্রি করা হয়েছে";
        break;
      case 'updated':
        $description = "দৈনিক ঋণ প্রদান এন্ট্রি আপডেট করা হয়েছে";
        break;
      case 'deleted':
        $description = "দৈনিক ঋণ প্রদান থেকে এন্ট্রি ডিলেট করা হয়েছে";
        break;
      default:
        $description = "দৈনিক ঋণ {$eventName}";
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
  public function manager()
  {
    return $this->belongsTo(Manager::class);
  }

  public function package()
  {
    return $this->belongsTo(DailyLoanPackage::class, 'package_id');
  }

  public function dailySaving()
  {
    return $this->belongsTo(DailySavings::class);
  }

  public function guarantors()
  {
    return $this->hasMany(Guarantor::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function createdBy()
  {
    return $this->belongsTo(User::class, 'created_by');
  }

  public function approvedBy()
  {
    return $this->belongsTo(User::class, 'approved_by');
  }

  public function adjustAmounts()
  {
    return $this->hasMany(AdjustAmount::class);
  }

  public function dailyCollections()
  {
    return $this->hasMany(DailyCollection::class);
  }

  public function dailyLoanCollections()
  {
    return $this->hasMany(DailyLoanCollection::class);
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
        'transactionable_type' => DailyLoan::class,
        'date' => $loan->opening_date,
        'manager_id' => Auth::id()
      ]);
    });

    // Define the deleting event callback
    static::deleting(function ($loan) {
      $loan->transactions()->delete();
    });
  }
}
