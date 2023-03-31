<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DpsCollection;
use Illuminate\Auth\Access\HandlesAuthorization;

class DpsCollectionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the dpsCollection can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list dpscollections');
    }

    /**
     * Determine whether the dpsCollection can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsCollection  $model
     * @return mixed
     */
    public function view(User $user, DpsCollection $model)
    {
        return $user->hasPermissionTo('view dpscollections');
    }

    /**
     * Determine whether the dpsCollection can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create dpscollections');
    }

    /**
     * Determine whether the dpsCollection can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsCollection  $model
     * @return mixed
     */
    public function update(User $user, DpsCollection $model)
    {
        return $user->hasPermissionTo('update dpscollections');
    }

    /**
     * Determine whether the dpsCollection can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsCollection  $model
     * @return mixed
     */
    public function delete(User $user, DpsCollection $model)
    {
        return $user->hasPermissionTo('delete dpscollections');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsCollection  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete dpscollections');
    }

    /**
     * Determine whether the dpsCollection can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsCollection  $model
     * @return mixed
     */
    public function restore(User $user, DpsCollection $model)
    {
        return false;
    }

    /**
     * Determine whether the dpsCollection can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsCollection  $model
     * @return mixed
     */
    public function forceDelete(User $user, DpsCollection $model)
    {
        return false;
    }
}
