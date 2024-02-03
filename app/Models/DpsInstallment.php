<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class DpsInstallment extends Model
{
  use HasFactory;
  use Searchable;
  use LogsActivity;
  protected $fillable = [
    'account_no',
    'user_id',
    'dps_id',
    'dps_loan_id',
    'dps_amount',
    'dps_balance',
    'receipt_no',
    'late_fee',
    'loan_late_fee',
    'other_fee',
    'loan_other_fee',
    'dps_installments',
    'loan_installments',
    'grace',
    'loan_grace',
    'advance',
    'loan_installment',
    'interest',
    'trx_id',
    'loan_balance',
    'total',
    'due',
    'due_return',
    'due_interest',
    'unpaid_interest',
    'advance_return',
    'date',
    'dps_note',
    'loan_note',
    'deposited_via',
    'deposited_via_details',
    'collector_date',
    'is_sms_sent',
    'manager_id'
  ];

  protected $searchableFields = ['*'];

  protected $table = 'dps_installments';

  public function dpsLoanInterest()
  {
    return $this->hasOne(DpsLoanInterest::class, 'dps_installment_id');
  }

  public function loanPayment()
  {
    return $this->hasOne(LoanPayment::class, 'dps_installment_id');
  }

  public function transaction()
  {
    return $this->morphOne(Transaction::class, 'transactionable');
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function dps()
  {
    return $this->belongsTo(Dps::class);
  }

  public function manager()
  {
    return $this->belongsTo(Manager::class);
  }

  public function dpsLoan()
  {
    return $this->belongsTo(DpsLoan::class);
  }

  public function dpsCollections()
  {
    return $this->hasMany(DpsCollection::class);
  }

  public function dpsLoanCollections()
  {
    return $this->hasMany(DpsLoanCollection::class);
  }

  protected static function boot()
  {
    parent::boot();

    static::created(function ($installment) {
      Transaction::create([
        'account_no' => $installment->account_no,
        'user_id' => $installment->user_id,
        'amount' => $installment->total,
        'type' => 'cashin',
        'transactionable_id' => $installment->id,
        'transactionable_type' => DpsInstallment::class,
        'date' => $installment->date,
        'manager_id' => Auth::id()
      ]);
    });

    static::deleting(function ($installment) {
      $installment->transaction->delete();
    });

    /*static::updated(function ($installment) {
      $transaction = Transaction::where('transactionable_id', $installment->id)
        ->where('transactionable_type', DpsInstallment::class)
        ->first();

      if ($transaction) {
        $transaction->update([
          'amount' => $installment->total,
          'date' => $installment->date,
          'manager_id' => Auth::id()
        ]);
      }else{
        Transaction::create([
          'account_no' => $installment->account_no,
          'user_id' => $installment->user_id,
          'amount' => $installment->total,
          'type' => 'cashin',
          'transactionable_id' => $installment->id,
          'transactionable_type' => DpsInstallment::class,
          'date' => $installment->date,
          'manager_id' => $installment->manager_id
        ]);
      }
    });*/
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
      'loan_installment' => 'ঋন ফেরত',
      'dps_amount' => 'সঞ্চয় জমা',
      'date' => 'তারিখ',
    ];

    // Get the original description
    $description = "";

    switch ($eventName) {
      case 'created':
        $description = "মাসিক সঞ্চয়/ঋণ আদায় নতুন এন্ট্রি করা হয়েছে";
        break;
      case 'updated':
        $description = "মাসিক সঞ্চয়/ঋণ এন্ট্রি আপডেট করা হয়েছে";
        break;
      case 'deleted':
        $description = "মাসিক সঞ্চয়/ঋণ থেকে এন্ট্রি ডিলেট করা হয়েছে";
        break;
      default:
        $description = "মাসিক সঞ্চয়/ঋণ {$eventName}";
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
