<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DpsInstallment extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'account_no',
        'user_id',
        'dps_id',
        'collector_id',
        'dps_loan_id',
        'dps_amount',
        'dps_balance',
        'receipt_no',
        'late_fee',
        'loan_late_fee',
        'other_fee',
        'loan_other_fee',
        'dps_installments',
        'loan_installments',
        'grace',
        'loan_grace',
        'advance',
        'loan_installment',
        'interest',
        'trx_id',
        'loan_balance',
        'total',
        'due',
        'due_return',
        'due_interest',
        'unpaid_interest',
        'advance_return',
        'date',
        'dps_note',
        'loan_note',
        'deposited_via',
        'deposited_via_details'
    ];

    protected $searchableFields = ['*'];

    protected $table = 'dps_installments';

    protected $casts = [
        'date' => 'date',
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dps()
    {
        return $this->belongsTo(Dps::class);
    }

    public function collector()
    {
        return $this->belongsTo(User::class, 'collector_id');
    }

    public function dpsLoan()
    {
        return $this->belongsTo(DpsLoan::class);
    }

    public function dpsCollections()
    {
        return $this->hasMany(DpsCollection::class);
    }

    public function dpsLoanCollections()
    {
        return $this->hasMany(DpsLoanCollection::class);
    }
}
