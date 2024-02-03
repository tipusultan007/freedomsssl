<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dps extends Model
{
  use HasFactory;
  use Searchable;

  protected $fillable = [
    'account_no',
    'user_id',
    'dps_package_id',
    'package_amount',
    'principal_profit',
    'duration',
    'receipt_book',
    'withdraw',
    'profit',
    'balance',
    'total',
    'deposited',
    'remain_profit',
    'status',
    'introducer_id',
    'opening_date',
    'commencement',
    'note',
    'is_sms_sent',
    'manager_id'
  ];

  protected $searchableFields = ['*'];


  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function loan()
  {
    return $this->hasOne(DpsLoan::class,'account_no','account_no');
  }

  public function dpsPackage()
  {
    return $this->belongsTo(DpsPackage::class);
  }

  public function createdBy()
  {
    return $this->belongsTo(User::class, 'created_by');
  }

  public function dpsInstallments()
  {
    return $this->hasMany(DpsInstallment::class);
  }

  public function dpsCollections()
  {
    return $this->hasMany(DpsCollection::class);
  }

  public function closingAccounts()
  {
    return $this->hasMany(ClosingAccount::class);
  }

  public function introducer()
  {
    return $this->belongsTo(User::class, 'introducer_id');
  }

  public function loans()
  {
    return $this->hasMany(TakenLoan::class,'account_no','account_no');
  }
  public function nominee()
  {
    return $this->hasOne(Nominees::class,'account_no','account_no');
  }

  public function dpsCompletes()
  {
    return $this->hasMany(DpsComplete::class);
  }
}
