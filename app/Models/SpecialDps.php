<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class SpecialDps extends Model
{
  use HasFactory;
  use Searchable;

  protected $fillable = [
    'account_no',
    'user_id',
    'special_dps_package_id',
    'package_amount',
    'initial_amount',
    'principal_profit',
    'duration',
    'receipt_book',
    'balance',
    'deposited',
    'withdraw',
    'total',
    'profit',
    'remain_profit',
    'status',
    'introducer_id',
    'opening_date',
    'commencement',
    'trx_id',
    'is_sms_sent',
    'manager_id'
  ];

  protected $searchableFields = ['*'];

  protected $table = 'special_dps';

  public function manager()
  {
    return $this->belongsTo(Manager::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }
public function loan()
  {
    return $this->hasOne(SpecialDpsLoan::class,'account_no','account_no');
  }

  public function installments()
  {
    return $this->hasMany(SpecialInstallment::class);
  }
  public function dpsCollections()
  {
    return $this->hasMany(SpecialDpsCollection::class);
  }
  public function specialDpsPackage()
  {
    return $this->belongsTo(SpecialDpsPackage::class);
  }

  public function createdBy()
  {
    return $this->belongsTo(User::class, 'created_by');
  }

  public function closingAccounts()
  {
    return $this->hasMany(ClosingAccount::class);
  }

  public function introducer()
  {
    return $this->belongsTo(User::class, 'introducer_id');
  }

  public function nominee()
  {
    return $this->hasOne(Nominees::class, 'account_no', 'account_no');
  }

  public function givenLoans()
  {
    return $this->hasMany(SpecialLoanTaken::class, 'account_no', 'account_no');
  }

  public function transactions()
  {
    return $this->morphMany(Transaction::class, 'transactionable');
  }

  protected static function boot()
  {
    parent::boot();

    static::created(function ($dps) {
      // Create a new Transaction record
      Transaction::create([
        'account_no' => $dps->account_no,
        'user_id' => $dps->user_id,
        'description' => 'প্রাথমিক জমা',
        'amount' => $dps->initial_amount,
        'type' => 'cashin',
        'transactionable_id' => $dps->id,
        'transactionable_type' => SpecialDps::class,
        'date' => $dps->opening_date,
        'manager_id' => Auth::id()
      ]);
    });

    // Define the deleting event callback
    static::deleting(function ($dps) {
      $dps->transactions()->delete();
    });
  }

  public function dpsCompletes()
  {
    return $this->hasMany(SpecialDpsComplete::class);
  }
}
