<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DailySavingsClosing extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_no',
        'daily_savings_id',
        'daily_loan_id',
        'deposit',
        'profit',
        'payable',
        'loan',
        'grace',
        'receivable',
        'total',
        'date',
        'service_charge',
        'closing_by',
        'trx_id',
      'manager_id'
    ];

    protected $table = 'daily_savings_closings';

    protected $casts = [
        'date' => 'date',
    ];
  public function manager()
  {
    return $this->belongsTo(Manager::class);
  }
    public function dailySavings()
    {
        return $this->belongsTo(DailySavings::class);
    }

    public function closedBy()
    {
        return $this->belongsTo(User::class,'closing_by','id');
    }

}
