<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FdrPackage;
use Illuminate\Auth\Access\HandlesAuthorization;

class FdrPackagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the fdrPackage can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list fdrpackages');
    }

    /**
     * Determine whether the fdrPackage can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FdrPackage  $model
     * @return mixed
     */
    public function view(User $user, FdrPackage $model)
    {
        return $user->hasPermissionTo('view fdrpackages');
    }

    /**
     * Determine whether the fdrPackage can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create fdrpackages');
    }

    /**
     * Determine whether the fdrPackage can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FdrPackage  $model
     * @return mixed
     */
    public function update(User $user, FdrPackage $model)
    {
        return $user->hasPermissionTo('update fdrpackages');
    }

    /**
     * Determine whether the fdrPackage can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FdrPackage  $model
     * @return mixed
     */
    public function delete(User $user, FdrPackage $model)
    {
        return $user->hasPermissionTo('delete fdrpackages');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FdrPackage  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete fdrpackages');
    }

    /**
     * Determine whether the fdrPackage can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FdrPackage  $model
     * @return mixed
     */
    public function restore(User $user, FdrPackage $model)
    {
        return false;
    }

    /**
     * Determine whether the fdrPackage can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FdrPackage  $model
     * @return mixed
     */
    public function forceDelete(User $user, FdrPackage $model)
    {
        return false;
    }
}
