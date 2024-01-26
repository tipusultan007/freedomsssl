<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Manager extends Authenticatable
{
  use Notifiable;

  protected $guard = 'manager';

  protected $fillable = [
    'name', 'phone', 'password',
  ];

  protected $hidden = [
    'password', 'remember_token',
  ];

  public function transactions(){
    return $this->hasMany(Transaction::class);
  }
}
