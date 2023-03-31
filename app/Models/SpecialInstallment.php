<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialInstallment extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_no',
        'user_id',
        'special_dps_id',
        'collector_id',
        'special_dps_loan_id',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dps()
    {
        return $this->belongsTo(SpecialDps::class);
    }

    public function collector()
    {
        return $this->belongsTo(User::class, 'collector_id');
    }

    public function dpsLoan()
    {
        return $this->belongsTo(SpecialDpsLoan::class);
    }

    public function dpsCollections()
    {
        return $this->hasMany(SpecialDpsCollection::class);
    }

    public function dpsLoanCollections()
    {
        return $this->hasMany(SpecialLoanCollection::class);
    }
}
