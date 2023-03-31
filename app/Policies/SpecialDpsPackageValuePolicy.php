<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SpecialDpsPackageValue;
use Illuminate\Auth\Access\HandlesAuthorization;

class SpecialDpsPackageValuePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the specialDpsPackageValue can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list specialdpspackagevalues');
    }

    /**
     * Determine whether the specialDpsPackageValue can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SpecialDpsPackageValue  $model
     * @return mixed
     */
    public function view(User $user, SpecialDpsPackageValue $model)
    {
        return $user->hasPermissionTo('view specialdpspackagevalues');
    }

    /**
     * Determine whether the specialDpsPackageValue can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create specialdpspackagevalues');
    }

    /**
     * Determine whether the specialDpsPackageValue can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SpecialDpsPackageValue  $model
     * @return mixed
     */
    public function update(User $user, SpecialDpsPackageValue $model)
    {
        return $user->hasPermissionTo('update specialdpspackagevalues');
    }

    /**
     * Determine whether the specialDpsPackageValue can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SpecialDpsPackageValue  $model
     * @return mixed
     */
    public function delete(User $user, SpecialDpsPackageValue $model)
    {
        return $user->hasPermissionTo('delete specialdpspackagevalues');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SpecialDpsPackageValue  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete specialdpspackagevalues');
    }

    /**
     * Determine whether the specialDpsPackageValue can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SpecialDpsPackageValue  $model
     * @return mixed
     */
    public function restore(User $user, SpecialDpsPackageValue $model)
    {
        return false;
    }

    /**
     * Determine whether the specialDpsPackageValue can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SpecialDpsPackageValue  $model
     * @return mixed
     */
    public function forceDelete(User $user, SpecialDpsPackageValue $model)
    {
        return false;
    }
}
