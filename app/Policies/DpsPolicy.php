<?php

namespace App\Policies;

use App\Models\Dps;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DpsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the dps can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list alldps');
    }

    /**
     * Determine whether the dps can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Dps  $model
     * @return mixed
     */
    public function view(User $user, Dps $model)
    {
        return $user->hasPermissionTo('view alldps');
    }

    /**
     * Determine whether the dps can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create alldps');
    }

    /**
     * Determine whether the dps can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Dps  $model
     * @return mixed
     */
    public function update(User $user, Dps $model)
    {
        return $user->hasPermissionTo('update alldps');
    }

    /**
     * Determine whether the dps can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Dps  $model
     * @return mixed
     */
    public function delete(User $user, Dps $model)
    {
        return $user->hasPermissionTo('delete alldps');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Dps  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete alldps');
    }

    /**
     * Determine whether the dps can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Dps  $model
     * @return mixed
     */
    public function restore(User $user, Dps $model)
    {
        return false;
    }

    /**
     * Determine whether the dps can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Dps  $model
     * @return mixed
     */
    public function forceDelete(User $user, Dps $model)
    {
        return false;
    }
}
