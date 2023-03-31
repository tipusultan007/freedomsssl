<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DpsPackageValue;
use Illuminate\Auth\Access\HandlesAuthorization;

class DpsPackageValuePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the dpsPackageValue can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list dpspackagevalues');
    }

    /**
     * Determine whether the dpsPackageValue can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsPackageValue  $model
     * @return mixed
     */
    public function view(User $user, DpsPackageValue $model)
    {
        return $user->hasPermissionTo('view dpspackagevalues');
    }

    /**
     * Determine whether the dpsPackageValue can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create dpspackagevalues');
    }

    /**
     * Determine whether the dpsPackageValue can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsPackageValue  $model
     * @return mixed
     */
    public function update(User $user, DpsPackageValue $model)
    {
        return $user->hasPermissionTo('update dpspackagevalues');
    }

    /**
     * Determine whether the dpsPackageValue can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsPackageValue  $model
     * @return mixed
     */
    public function delete(User $user, DpsPackageValue $model)
    {
        return $user->hasPermissionTo('delete dpspackagevalues');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsPackageValue  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete dpspackagevalues');
    }

    /**
     * Determine whether the dpsPackageValue can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsPackageValue  $model
     * @return mixed
     */
    public function restore(User $user, DpsPackageValue $model)
    {
        return false;
    }

    /**
     * Determine whether the dpsPackageValue can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsPackageValue  $model
     * @return mixed
     */
    public function forceDelete(User $user, DpsPackageValue $model)
    {
        return false;
    }
}
