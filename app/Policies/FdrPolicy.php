<?php

namespace App\Policies;

use App\Models\Fdr;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FdrPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the fdr can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list fdrs');
    }

    /**
     * Determine whether the fdr can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Fdr  $model
     * @return mixed
     */
    public function view(User $user, Fdr $model)
    {
        return $user->hasPermissionTo('view fdrs');
    }

    /**
     * Determine whether the fdr can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create fdrs');
    }

    /**
     * Determine whether the fdr can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Fdr  $model
     * @return mixed
     */
    public function update(User $user, Fdr $model)
    {
        return $user->hasPermissionTo('update fdrs');
    }

    /**
     * Determine whether the fdr can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Fdr  $model
     * @return mixed
     */
    public function delete(User $user, Fdr $model)
    {
        return $user->hasPermissionTo('delete fdrs');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Fdr  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete fdrs');
    }

    /**
     * Determine whether the fdr can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Fdr  $model
     * @return mixed
     */
    public function restore(User $user, Fdr $model)
    {
        return false;
    }

    /**
     * Determine whether the fdr can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Fdr  $model
     * @return mixed
     */
    public function forceDelete(User $user, Fdr $model)
    {
        return false;
    }
}
