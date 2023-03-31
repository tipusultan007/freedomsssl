<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DailyLoanCollection extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'account_no',
        'daily_loan_id',
        'loan_installment',
        'installment_no',
        'loan_late_fee',
        'loan_other_fee',
        'loan_note',
        'loan_balance',
        'collector_id',
        'date',
        'user_id',
        'collection_id',
        'created_by',
        'trx_id'
    ];

    protected $searchableFields = ['*'];

    protected $table = 'daily_loan_collections';

    protected $casts = [
        'date' => 'date',
    ];
    function getDateAttribute($date)
    {
        return Carbon::createFromDate($date)->format('d-m-Y');
    }
    public function dailyLoan()
    {
        return $this->belongsTo(DailyLoan::class);
    }

    public function collector()
    {
        return $this->belongsTo(User::class, 'collector_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
