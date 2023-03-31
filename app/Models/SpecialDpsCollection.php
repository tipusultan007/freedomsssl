<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialDpsCollection extends Model
{
    use HasFactory;


    protected $fillable = [
        'account_no',
        'user_id',
        'special_dps_id',
        'dps_amount',
        'balance',
        'month',
        'year',
        'date',
        'collector_id',
        'special_installment_id',
    ];
}
