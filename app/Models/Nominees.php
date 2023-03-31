<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nominees extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'account_no',
        'name',
        'address',
        'phone',
        'relation',
        'percentage',
        'user_id',
    ];

    protected $searchableFields = ['*'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
