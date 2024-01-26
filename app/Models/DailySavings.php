<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DailySavings extends Model
{
  use HasFactory;
  use Searchable;

  protected $fillable = [
    'account_no',
    'user_id',
    'opening_date',
    'introducer_id',
    'status',
    'deposit',
    'withdraw',
    'profit',
    'remain_profit',
    'total',
    'is_sms_sent',
    'manager_id'
  ];

  protected $searchableFields = ['*'];

  protected $table = 'daily_savings';

  public function manager()
  {
    return $this->belongsTo(Manager::class);
  }


  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function dailyLoans()
  {
    return $this->hasMany(DailyLoan::class);
  }

  public function introducer()
  {
    return $this->belongsTo(User::class, 'introducer_id');
  }

  public function createdBy()
  {
    return $this->belongsTo(User::class, 'created_by');
  }

  public function dailySavingsCompletes()
  {
    return $this->hasMany(DailySavingsComplete::class);
  }

  public function dailyCollections()
  {
    return $this->hasMany(DailyCollection::class);
  }

  public function savingsCollections()
  {
    return $this->hasMany(SavingsCollection::class);
  }

  public function addProfits()
  {
    return $this->hasMany(AddProfit::class);
  }

  public function closingAccounts()
  {
    return $this->hasMany(ClosingAccount::class);
  }

  public function nominee()
  {
    return $this->hasOne(Nominees::class, 'account_no', 'account_no');
  }
}
