<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DailySavings;
use Illuminate\Auth\Access\HandlesAuthorization;

class DailySavingsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the dailySavings can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list alldailysavings');
    }

    /**
     * Determine whether the dailySavings can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailySavings  $model
     * @return mixed
     */
    public function view(User $user, DailySavings $model)
    {
        return $user->hasPermissionTo('view alldailysavings');
    }

    /**
     * Determine whether the dailySavings can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create alldailysavings');
    }

    /**
     * Determine whether the dailySavings can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailySavings  $model
     * @return mixed
     */
    public function update(User $user, DailySavings $model)
    {
        return $user->hasPermissionTo('update alldailysavings');
    }

    /**
     * Determine whether the dailySavings can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailySavings  $model
     * @return mixed
     */
    public function delete(User $user, DailySavings $model)
    {
        return $user->hasPermissionTo('delete alldailysavings');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailySavings  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete alldailysavings');
    }

    /**
     * Determine whether the dailySavings can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailySavings  $model
     * @return mixed
     */
    public function restore(User $user, DailySavings $model)
    {
        return false;
    }

    /**
     * Determine whether the dailySavings can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailySavings  $model
     * @return mixed
     */
    public function forceDelete(User $user, DailySavings $model)
    {
        return false;
    }
}
