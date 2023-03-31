<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FdrProfit extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'account_no',
        'user_id',
        'fdr_id',
        'profit',
        'balance',
        'date',
        'grace',
        'other_fee',
        'created_by',
        'trx_id',
        'month',
        'year',
        'note',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'fdr_profits';

    protected $casts = [
        'date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fdr()
    {
        return $this->belongsTo(Fdr::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
