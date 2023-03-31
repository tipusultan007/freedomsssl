<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SpecialDps extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'account_no',
        'user_id',
        'special_dps_package_id',
        'package_amount',
        'initial_amount',
        'principal_profit',
        'duration',
        'receipt_book',
        'balance',
        'created_by',
        'status',
        'introducer_id',
        'opening_date',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'special_dps';

    protected $casts = [
        'opening_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function specialDpsPackage()
    {
        return $this->belongsTo(SpecialDpsPackage::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function closingAccounts()
    {
        return $this->hasMany(ClosingAccount::class);
    }

    public function introducer()
    {
        return $this->belongsTo(User::class,'introducer_id');
    }
}
