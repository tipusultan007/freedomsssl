<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function Symfony\Component\Translation\t;

class Account extends Model
{
    use HasFactory;

    protected $fillable = ['name','description','balance','account_type_id'];

    public function type()
    {
        return $this->belongsTo(AccountType::class,'account_type_id','id');
    }
}
