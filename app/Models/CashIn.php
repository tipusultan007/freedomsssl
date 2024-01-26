<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CashIn extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'user_id',
        'cashin_category_id',
        'account_no',
        'daily_collection_id',
        'dps_installment_id',
        'special_installment_id',
        'frd_deposit_id',
        'special_dps_id',
        'amount',
        'trx_id',
        'description',
        'date',
      'manager_id'
    ];

    protected $searchableFields = ['*'];

    protected $table = 'cash_ins';

    protected $casts = [
        'date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function cashinCategory()
    {
        return $this->belongsTo(CashinCategory::class);
    }
}
