<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class DailyLoanCollection extends Model
{
  use HasFactory;
  use Searchable;
  use LogsActivity;

  protected $fillable = [
    'account_no',
    'daily_loan_id',
    'loan_installment',
    'installment_no',
    'loan_late_fee',
    'loan_other_fee',
    'loan_note',
    'loan_balance',
    'collector_id',
    'date',
    'user_id',
    'collection_id',
    'created_by',
    'trx_id',
    'manager_id'
  ];

  protected $searchableFields = ['*'];

  protected $table = 'daily_loan_collections';
  public function manager()
  {
    return $this->belongsTo(Manager::class);
  }
  public function dailyLoan()
  {
    return $this->belongsTo(DailyLoan::class);
  }

  public function transaction()
  {
    return $this->morphOne(Transaction::class, 'transactionable');
  }

  public function collector()
  {
    return $this->belongsTo(User::class, 'collector_id');
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function createdBy()
  {
    return $this->belongsTo(User::class, 'created_by');
  }

  protected static function boot()
  {
    parent::boot();

    static::created(function ($loanCollection) {
      // Create a new Transaction record
      Transaction::create([
        'account_no' => $loanCollection->account_no,
        'user_id' => $loanCollection->user_id,
        'amount' => $loanCollection->loan_installment + $loanCollection->loan_late_fee + $loanCollection->loan_other_fee,
        'type' => 'cashin',
        'transactionable_id' => $loanCollection->id,
        'transactionable_type' => DailyLoanCollection::class,
        'date' => $loanCollection->date,
        'manager_id' => Auth::id()
      ]);
    });

    // Define the deleting event callback
    static::deleting(function ($loanCollection) {
      $loanCollection->transaction->delete();
    });
  }

  /**
   * @return LogOptions
   */
  public function getActivitylogOptions(): LogOptions
  {
    return LogOptions::defaults()->logAll();
  }
  public function getDescriptionForEvent(string $eventName): string
  {
    // Define custom property names based on the event
    $customPropertyNames = [
      'account_no' => 'হিসাব নং',
      'loan_installment' => 'পরিমাণ',
      'daily_loan_id' => 'ঋণ ID',
      'date' => 'তারিখ',
    ];

    // Get the original description
    $description = "";

    switch ($eventName) {
      case 'created':
        $description = "দৈনিক ঋণ আদায় নতুন এন্ট্রি করা হয়েছে";
        break;
      case 'updated':
        $description = "দৈনিক ঋণ আদায় এন্ট্রি আপডেট করা হয়েছে";
        break;
      case 'deleted':
        $description = "দৈনিক ঋণ আদায় থেকে এন্ট্রি ডিলেট করা হয়েছে";
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
}
