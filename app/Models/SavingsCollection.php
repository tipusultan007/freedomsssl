<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SavingsCollection extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'account_no',
        'daily_savings_id',
        'saving_amount',
        'type',
        'late_fee',
        'other_fee',
        'collector_id',
        'date',
        'balance',
        'user_id',
        'collection_id',
        'created_by',
        'trx_id'
    ];

    protected $searchableFields = ['*'];

    protected $table = 'savings_collections';

    protected $casts = [
        'date' => 'date',
    ];

    function getDateAttribute($date)
    {
        return Carbon::createFromDate($date)->format('d-m-Y');
    }

    public function dailySavings()
    {
        return $this->belongsTo(DailySavings::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function collector()
    {
        return $this->belongsTo(User::class, 'collector_id');
    }
}
