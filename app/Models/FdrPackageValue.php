<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FdrPackageValue extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['fdr_package_id', 'year', 'amount'];

    protected $searchableFields = ['*'];

    protected $table = 'fdr_package_values';

    public function fdrPackage()
    {
        return $this->belongsTo(FdrPackage::class);
    }
}
