<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClosingAccount extends Model
{
    use HasFactory;
    protected $fillable = [
        'account_no',
        'user_id',
        'type',
        'deposit',
        'withdraw',
        'remain',
        'profit',
        'service_charge',
        'total',
        'date',
        'created_by',
        'daily_savings_id',
        'dps_id',
        'special_dps_id',
        'fdr_id',
        'trx_id',
      'is_sms_sent',
      'manager_id'
    ];


    protected $table = 'closing_accounts';

  public function manager()
  {
    return $this->belongsTo(Manager::class);
  }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function dailySavings()
    {
        return $this->belongsTo(DailySavings::class);
    }

    public function dps()
    {
        return $this->belongsTo(Dps::class);
    }

    public function specialDps()
    {
        return $this->belongsTo(SpecialDps::class);
    }

    public function fdr()
    {
        return $this->belongsTo(Fdr::class);
    }
}
