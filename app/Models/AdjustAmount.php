<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdjustAmount extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'loan_id',
        'daily_loan_id',
        'adjust_amount',
        'before_adjust',
        'after_adjust',
        'date',
        'added_by',
      'manager_id'
    ];

    protected $searchableFields = ['*'];

    protected $table = 'adjust_amounts';

    protected $casts = [
        'date' => 'date',
    ];

    public function dailyLoan()
    {
        return $this->belongsTo(DailyLoan::class);
    }

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
