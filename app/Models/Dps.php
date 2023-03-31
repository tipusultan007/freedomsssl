<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dps extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'account_no',
        'user_id',
        'dps_package_id',
        'package_amount',
        'principal_profit',
        'duration',
        'receipt_book',
        'balance',
        'status',
        'introducer_id',
        'created_by',
        'opening_date',
        'commencement',
        'note'
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'opening_date' => 'date',
    ];
    function getOpeningDateAttribute($date)
    {
        return Carbon::createFromDate($date)->format('Y-m-d');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dpsPackage()
    {
        return $this->belongsTo(DpsPackage::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function dpsInstallments()
    {
        return $this->hasMany(DpsInstallment::class);
    }

    public function dpsCollections()
    {
        return $this->hasMany(DpsCollection::class);
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
