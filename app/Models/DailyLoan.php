<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DailyLoan extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'package_id',
        'account_no',
        'per_installment',
        'opening_date',
        'interest',
        'adjusted_amount',
        'commencement',
        'loan_amount',
        'total',
        'application_date',
        'created_by',
        'approved_by',
        'status',
        'balance',
        'grace',
        'paid_interest',
        'trx_id'
    ];

    protected $searchableFields = ['*'];

    protected $table = 'daily_loans';

    protected $casts = [
        'opening_date' => 'date',
        'commencement' => 'date',
        'application_date' => 'date',
    ];

    public function package()
    {
        return $this->belongsTo(DailyLoanPackage::class, 'package_id');
    }

    public function guarantors()
    {
        return $this->hasMany(Guarantor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function adjustAmounts()
    {
        return $this->hasMany(AdjustAmount::class);
    }

    public function dailyCollections()
    {
        return $this->hasMany(DailyCollection::class);
    }

    public function dailyLoanCollections()
    {
        return $this->hasMany(DailyLoanCollection::class);
    }
}
