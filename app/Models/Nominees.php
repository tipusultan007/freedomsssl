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
    'name1',
    'address',
    'address1',
    'phone',
    'phone1',
    'birthdate',
    'birthdate1',
    'relation',
    'relation1',
    'percentage',
    'percentage1',
    'user_id',
    'user_id1',
    'image',
    'image1',
  ];

  protected $searchableFields = ['*'];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function user2()
  {
    return $this->belongsTo(User::class,'user_id1');
  }

  public function dps()
  {
    return $this->belongsTo(Dps::class,'account_no','account_no');
  }
  public function specialDps()
  {
    return $this->belongsTo(SpecialDps::class,'account_no','account_no');
  }

  public function fdr()
  {
    return $this->belongsTo(Fdr::class,'account_no','account_no');
  }

}
