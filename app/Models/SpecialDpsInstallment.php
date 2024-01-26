<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialDpsInstallment extends Model
{
    use HasFactory;

  public function manager()
  {
    return $this->belongsTo(Manager::class);
  }
}
