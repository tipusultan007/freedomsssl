<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DpsPackageValue extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['dps_package_id', 'year', 'amount'];

    protected $searchableFields = ['*'];

    protected $table = 'dps_package_values';

    public function dpsPackage()
    {
        return $this->belongsTo(DpsPackage::class);
    }
}
