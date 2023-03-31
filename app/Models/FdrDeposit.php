<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FdrDeposit extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'account_no',
        'fdr_id',
        'user_id',
        'amount',
        'fdr_package_id',
        'date',
        'commencement',
        'balance',
        'profit',
        'created_by',
        'note',
        'trx_id',
        'deposited_via',
        'deposited_via_details'
    ];

    protected $searchableFields = ['*'];

    protected $table = 'fdr_deposits';

    protected $casts = [
        'date' => 'date',
        'commencement' => 'date',
    ];

    function getDateAttribute($date)
    {
        return Carbon::createFromDate($date)->format('Y-m-d');
    }
    function getCommencementAttribute($date)
    {
        return Carbon::createFromDate($date)->format('Y-m-d');
    }
    public function fdr()
    {
        return $this->belongsTo(Fdr::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fdrPackage()
    {
        return $this->belongsTo(FdrPackage::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function fdrWithdraws()
    {
        return $this->hasMany(FdrWithdraw::class);
    }
}
