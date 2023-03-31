<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fdr extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'account_no',
        'user_id',
        'fdr_package_id',
        'duration',
        'date',
        'amount',
        'balance',
        'profit',
        'commencement',
        'note',
        'status',
        'created_by',
        'introducer_id',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'date' => 'date',
        'deposit_date' => 'date',
        'commencement' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fdrPackage()
    {
        return $this->belongsTo(FdrPackage::class);
    }

    public function fdrDeposits()
    {
        return $this->hasMany(FdrDeposit::class);
    }

    public function fdrWithdraws()
    {
        return $this->hasMany(FdrWithdraw::class);
    }

    public function fdrProfits()
    {
        return $this->hasMany(FdrProfit::class);
    }

    public function closingAccounts()
    {
        return $this->hasMany(ClosingAccount::class);
    }

    public function introducer()
    {
        return $this->belongsTo(User::class,'introducer_id');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class,'created_by');
    }
}
