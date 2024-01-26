<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DailyCollection extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'account_no',
        'user_id',
        'collector_id',
        'saving_amount',
        'saving_type',
        'late_fee',
        'other_fee',
        'loan_installment',
        'loan_late_fee',
        'loan_other_fee',
        'saving_note',
        'loan_note',
        'daily_savings_id',
        'daily_loan_id',
        'savings_balance',
        'loan_balance',
        'grace',
        'date',
        'collection_date',
        'created_by',
        'trx_id',
        'manager_id'
    ];

    protected $searchableFields = ['*'];

    protected $table = 'daily_collections';

  public function manager()
  {
    return $this->belongsTo(Manager::class);
  }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function collector()
    {
        return $this->belongsTo(User::class, 'collector_id');
    }

    public function dailySavings()
    {
        return $this->belongsTo(DailySavings::class);
    }

    public function dailyLoan()
    {
        return $this->belongsTo(DailyLoan::class);
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class,'created_by');
    }
}
