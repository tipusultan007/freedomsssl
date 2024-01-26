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
    'special_installment_id',
    'manager_id'
  ];

  public function manager()
  {
    return $this->belongsTo(Manager::class);
  }
}
