<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SpecialDpsPackageValue extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['special_dps_package_id', 'year', 'amount'];

    protected $searchableFields = ['*'];

    protected $table = 'special_dps_package_values';

    public function specialDpsPackage()
    {
        return $this->belongsTo(SpecialDpsPackage::class);
    }
}
