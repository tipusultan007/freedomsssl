<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FdrWithdraw extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'account_no',
        'user_id',
        'fdr_id',
        'date',
        'fdr_deposit_id',
        'amount',
        'note',
        'created_by',
        'balance',
        'trx_id'
    ];

    protected $searchableFields = ['*'];

    protected $table = 'fdr_withdraws';

    protected $casts = [
        'date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fdr()
    {
        return $this->belongsTo(Fdr::class);
    }

    public function fdrDeposit()
    {
        return $this->belongsTo(FdrDeposit::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
