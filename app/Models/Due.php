<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Due extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_no',
        'user_id',
        'due',
        'return',
        'balance',
        'dps_installment_id',
        'date'
    ];

    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
