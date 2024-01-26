<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfitCollection extends Model
{
    use HasFactory;

    protected $fillable = [
        'fdr_id',
        'fdr_profit_id',
        'fdr_deposit_id',
        'account_no',
        'installments',
        'profit',
        'total',
        'month',
        'year',
        'date',
    ];

    public function deposit()
    {
      return $this->belongsTo(FdrDeposit::class,'fdr_deposit_id','id');
    }
    public function fdrProfit()
    {
      return $this->belongsTo(FdrProfit::class);
    }
}
