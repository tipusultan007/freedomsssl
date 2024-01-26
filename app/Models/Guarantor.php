<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guarantor extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'user_id',
        'guarantor_user_id',
        'phone',
        'account_no',
        'name',
        'address',
        'exist_ac_no',
        'daily_loan_id',
        'taken_loan_id',
        'special_taken_loan_id',
    ];

    protected $searchableFields = ['*'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dailyLoan()
    {
        return $this->belongsTo(DailyLoan::class);
    }
}
