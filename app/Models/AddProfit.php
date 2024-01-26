<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AddProfit extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'daily_savings_id',
        'user_id',
        'account_no',
        'profit',
        'before_profit',
        'after_profit',
        'date',
        'duration',
      'manager_id'
    ];

    protected $searchableFields = ['*'];

    protected $table = 'add_profits';

    protected $casts = [
        'date' => 'date',
    ];

    public function dailySavings()
    {
        return $this->belongsTo(DailySavings::class);
    }

    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
