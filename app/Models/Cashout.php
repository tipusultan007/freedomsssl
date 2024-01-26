<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cashout extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'cashout_category_id',
        'account_no',
        'daily_collection_id',
        'fdr_profit_id',
        'fdr_withdraw_id',
        'fdr_deposit_id',
        'dps_loan_id',
        'special_loan_id',
        'daily_loan_id',
        'amount',
        'trx_id',
        'description',
        'date',
        'user_id',
      'manager_id'
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'date' => 'date',
    ];

    public function cashoutCategory()
    {
        return $this->belongsTo(CashoutCategory::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
