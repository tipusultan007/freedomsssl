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
}
