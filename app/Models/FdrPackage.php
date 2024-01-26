<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FdrPackage extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'amount','one','two','three','four','five','five_half','six'];

    protected $searchableFields = ['*'];

    protected $table = 'fdr_packages';

    public function fdrPackageValues()
    {
        return $this->hasMany(FdrPackageValue::class);
    }

    public function fdrs()
    {
        return $this->hasMany(Fdr::class);
    }

    public function fdrDeposits()
    {
        return $this->hasMany(FdrDeposit::class);
    }
}
