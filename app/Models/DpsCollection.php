<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DpsCollection extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'account_no',
        'user_id',
        'dps_id',
        'dps_amount',
        'balance',
        'month',
        'year',
        'date',
        'dps_installment_id',
        'manager_id'
    ];

    protected $searchableFields = ['*'];

    protected $table = 'dps_collections';


    public function collector()
    {
        return $this->belongsTo(User::class, 'collector_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dps()
    {
        return $this->belongsTo(Dps::class);
    }

    public function dpsInstallment()
    {
        return $this->belongsTo(DpsInstallment::class);
    }
}
