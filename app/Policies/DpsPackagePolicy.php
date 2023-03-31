<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DpsPackage;
use Illuminate\Auth\Access\HandlesAuthorization;

class DpsPackagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the dpsPackage can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list dpspackages');
    }

    /**
     * Determine whether the dpsPackage can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsPackage  $model
     * @return mixed
     */
    public function view(User $user, DpsPackage $model)
    {
        return $user->hasPermissionTo('view dpspackages');
    }

    /**
     * Determine whether the dpsPackage can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create dpspackages');
    }

    /**
     * Determine whether the dpsPackage can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsPackage  $model
     * @return mixed
     */
    public function update(User $user, DpsPackage $model)
    {
        return $user->hasPermissionTo('update dpspackages');
    }

    /**
     * Determine whether the dpsPackage can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsPackage  $model
     * @return mixed
     */
    public function delete(User $user, DpsPackage $model)
    {
        return $user->hasPermissionTo('delete dpspackages');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsPackage  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete dpspackages');
    }

    /**
     * Determine whether the dpsPackage can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsPackage  $model
     * @return mixed
     */
    public function restore(User $user, DpsPackage $model)
    {
        return false;
    }

    /**
     * Determine whether the dpsPackage can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsPackage  $model
     * @return mixed
     */
    public function forceDelete(User $user, DpsPackage $model)
    {
        return false;
    }
}
