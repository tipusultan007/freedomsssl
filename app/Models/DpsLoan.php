<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class DpsLoan extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;
    use Notifiable;

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
        'total_paid',
        'remain_loan',
        'paid_interest',
        'dueInterest',
        'grace',
        'installment',
        'note',
        'dueInstallment',
        'manager_id'
    ];

    protected $searchableFields = ['*'];

    protected $table = 'dps_loans';

    protected $casts = [
        'application_date' => 'date',
        'opening_date' => 'date',
        'commencement' => 'date',
        'dueInstallment' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function takenLoans()
    {
        return $this->hasMany(TakenLoan::class);
    }

    public function dpsInstallments()
    {
        return $this->hasMany(DpsInstallment::class);
    }

    public function dpsLoanCollections()
    {
        return $this->hasMany(DpsLoanCollection::class);
    }

    public function manager()
    {
      return $this->belongsTo(Manager::class);
    }
}
