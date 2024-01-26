<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Income extends Model
{
  use HasFactory;
  use Searchable;

  protected $fillable = [
    'income_category_id',
    'amount',
    'description',
    'date',
    'manager_id'
  ];


  public function incomeCategory()
  {
    return $this->belongsTo(IncomeCategory::class);
  }

  public function manager()
  {
    return $this->belongsTo(Manager::class);
  }
}
