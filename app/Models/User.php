<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone1',
        'phone2',
        'phone3',
        'present_address',
        'permanent_address',
        'occupation',
        'workplace',
        'national_id',
        'birth_id',
        'gender',
        'birthdate',
        'father_name',
        'mother_name',
        'spouse_name',
        'marital_status',
        'status',
        'wallet',
        'join_date',
        'profile_photo_path',
        'image',
      'manager_id',
      'due'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */

  public function manager()
  {
    return $this->belongsTo(Manager::class);
  }
  public function dailySavings():HasMany
    {
        return $this->hasMany(DailySavings::class);
    }

    public function dpsSavings():HasMany
    {
        return $this->hasMany(Dps::class);
    }
    public function specialDpsSavings():HasMany
    {
        return $this->hasMany(SpecialDps::class);
    }

    public function dailyLoans()
    {
        return $this->hasMany(DailyLoan::class);
    }

    public function dpsLoans():HasMany
    {
        return  $this->hasMany(DpsLoan::class);
    }

    public function specialLoans():HasMany
    {
        return $this->hasMany(SpecialDpsLoan::class);
    }

    public function fdrs():HasMany
    {
        return $this->hasMany(Fdr::class);
    }

}
