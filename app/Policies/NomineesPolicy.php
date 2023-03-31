<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Nominees;
use Illuminate\Auth\Access\HandlesAuthorization;

class NomineesPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the nominees can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list allnominees');
    }

    /**
     * Determine whether the nominees can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Nominees  $model
     * @return mixed
     */
    public function view(User $user, Nominees $model)
    {
        return $user->hasPermissionTo('view allnominees');
    }

    /**
     * Determine whether the nominees can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create allnominees');
    }

    /**
     * Determine whether the nominees can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Nominees  $model
     * @return mixed
     */
    public function update(User $user, Nominees $model)
    {
        return $user->hasPermissionTo('update allnominees');
    }

    /**
     * Determine whether the nominees can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Nominees  $model
     * @return mixed
     */
    public function delete(User $user, Nominees $model)
    {
        return $user->hasPermissionTo('delete allnominees');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Nominees  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete allnominees');
    }

    /**
     * Determine whether the nominees can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Nominees  $model
     * @return mixed
     */
    public function restore(User $user, Nominees $model)
    {
        return false;
    }

    /**
     * Determine whether the nominees can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Nominees  $model
     * @return mixed
     */
    public function forceDelete(User $user, Nominees $model)
    {
        return false;
    }
}
