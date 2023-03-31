<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SpecialDpsPackage;
use Illuminate\Auth\Access\HandlesAuthorization;

class SpecialDpsPackagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the specialDpsPackage can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list specialdpspackages');
    }

    /**
     * Determine whether the specialDpsPackage can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SpecialDpsPackage  $model
     * @return mixed
     */
    public function view(User $user, SpecialDpsPackage $model)
    {
        return $user->hasPermissionTo('view specialdpspackages');
    }

    /**
     * Determine whether the specialDpsPackage can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create specialdpspackages');
    }

    /**
     * Determine whether the specialDpsPackage can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SpecialDpsPackage  $model
     * @return mixed
     */
    public function update(User $user, SpecialDpsPackage $model)
    {
        return $user->hasPermissionTo('update specialdpspackages');
    }

    /**
     * Determine whether the specialDpsPackage can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SpecialDpsPackage  $model
     * @return mixed
     */
    public function delete(User $user, SpecialDpsPackage $model)
    {
        return $user->hasPermissionTo('delete specialdpspackages');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SpecialDpsPackage  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete specialdpspackages');
    }

    /**
     * Determine whether the specialDpsPackage can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SpecialDpsPackage  $model
     * @return mixed
     */
    public function restore(User $user, SpecialDpsPackage $model)
    {
        return false;
    }

    /**
     * Determine whether the specialDpsPackage can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SpecialDpsPackage  $model
     * @return mixed
     */
    public function forceDelete(User $user, SpecialDpsPackage $model)
    {
        return false;
    }
}
