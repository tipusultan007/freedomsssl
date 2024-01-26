<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
  use HasFactory;
  use Searchable;

  protected $fillable = [
    'expense_category_id',
    'amount',
    'description',
    'date',
    'manager_id'
  ];

  public function expenseCategory()
  {
    return $this->belongsTo(ExpenseCategory::class);
  }

  public function manager()
  {
    return $this->belongsTo(Manager::class);
  }
}
