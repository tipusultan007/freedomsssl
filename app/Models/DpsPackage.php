<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DpsPackage extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = ['name', 'amount','data'];

    protected $searchableFields = ['*'];

    protected $table = 'dps_packages';

    protected $casts = [
        'data' => 'array'
    ];

    protected function data(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }

    public function dpsPackageValues()
    {
        return $this->hasMany(DpsPackageValue::class);
    }

    public function allDps()
    {
        return $this->hasMany(Dps::class);
    }
}
