<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SpecialDpsPackage extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'amount'];

    protected $searchableFields = ['*'];

    protected $table = 'special_dps_packages';

    public function specialDpsPackageValues()
    {
        return $this->hasMany(SpecialDpsPackageValue::class);
    }

    public function allSpecialDps()
    {
        return $this->hasMany(SpecialDps::class);
    }
}
