<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DailySavingsClosing extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'account_no',
        'daily_savings_id',
        'total_deposit',
        'total_withdraw',
        'balance',
        'interest',
        'closing_by',
        'date',
        'closing_fee',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'daily_savings_closings';

    protected $casts = [
        'date' => 'date',
    ];

    public function dailySavings()
    {
        return $this->belongsTo(DailySavings::class);
    }

    public function closingBy()
    {
        return $this->belongsTo(User::class, 'closing_by');
    }
}
