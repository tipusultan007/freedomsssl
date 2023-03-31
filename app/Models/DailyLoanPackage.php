<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DailyLoanPackage extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = ['months', 'interest'];

    protected $searchableFields = ['*'];

    protected $table = 'daily_loan_packages';

    public function dailyLoans()
    {
        return $this->hasMany(DailyLoan::class, 'package_id');
    }
}
