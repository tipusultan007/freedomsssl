<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SpecialDpsLoan extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'account_no',
        'user_id',
        'loan_amount',
        'interest1',
        'interest2',
        'upto_amount',
        'application_date',
        'approved_by',
        'opening_date',
        'commencement',
        'status',
        'created_by',
        'total_paid',
        'remain_loan',
        'paid_interest',
        'dueInterest',
        'grace',
        'installment',
        'note',
        'dueInterest',
        'dueInstallment'
    ];

    protected $searchableFields = ['*'];

    protected $table = 'special_dps_loans';

    function getOpeningDateAttribute($date)
    {
        return Carbon::createFromDate($date)->format('d-m-Y');
    }
    function getCommencementAttribute($date)
    {
        return Carbon::createFromDate($date)->format('d-m-Y');
    }
    protected $casts = [
        'application_date' => 'date',
        'opening_date' => 'date',
        'commencement' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function specialLoanTakens()
    {
        return $this->hasMany(SpecialLoanTaken::class);
    }
}
