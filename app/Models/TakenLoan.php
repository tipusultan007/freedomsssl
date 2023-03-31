<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TakenLoan extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'account_no',
        'user_id',
        'loan_amount',
        'remain',
        'before_loan',
        'after_loan',
        'interest1',
        'interest2',
        'upto_amount',
        'date',
        'commencement',
        'created_by',
        'dps_loan_id',
        'approved_by',
        'installment',
        'note',
        'trx_id'
    ];

    protected $searchableFields = ['*'];

    protected $table = 'taken_loans';

    protected $casts = [
        'date' => 'date',
        'commencement' => 'date',
    ];

    function getDateAttribute($date)
    {
        return Carbon::createFromDate($date)->format('Y-m-d');
    }
    function getCommencementAttribute($date)
    {
        return Carbon::createFromDate($date)->format('Y-m-d');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function dpsLoan()
    {
        return $this->belongsTo(DpsLoan::class);
    }

    public function allLoanDocuments()
    {
        return $this->hasMany(LoanDocuments::class);
    }
}
