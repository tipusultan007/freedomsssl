<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DpsLoanCollection extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'account_no',
        'user_id',
        'dps_loan_id',
        'dps_installment_id',
        'trx_id',
        'loan_installment',
        'balance',
        'interest',
        'due_interest',
        'unpaid_interest',
        'date',
        'receipt_no',
        'manager_id'
    ];

    protected $searchableFields = ['*'];

    protected $table = 'dps_loan_collections';

    protected $casts = [
        'date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dpsLoan()
    {
        return $this->belongsTo(DpsLoan::class);
    }

    public function collector()
    {
        return $this->belongsTo(User::class, 'collector_id');
    }

    public function dpsInstallment()
    {
        return $this->belongsTo(DpsInstallment::class);
    }
}
