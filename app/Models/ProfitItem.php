<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfitItem extends Model
{
    use HasFactory;

    protected $fillable = [
      'account_no',
      'type',
      'profit',
      'date',
      'manager_id',
    ];
}
