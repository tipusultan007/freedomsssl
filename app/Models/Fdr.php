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
        'date',
        'amount',
        'balance',
        'profit',
        'commencement',
        'note',
        'status',
        'introducer_id',
         'manager_id'
    ];

  public static $rules = [
    'account_no' => 'unique:fdrs',
  ];
    protected $searchableFields = ['*'];

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


    public function nominee()
    {
      return $this->hasOne(Nominees::class,'account_no','account_no');
    }
}
