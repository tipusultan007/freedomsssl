<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DailyCollection;
use Illuminate\Auth\Access\HandlesAuthorization;

class DailyCollectionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the dailyCollection can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list dailycollections');
    }

    /**
     * Determine whether the dailyCollection can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailyCollection  $model
     * @return mixed
     */
    public function view(User $user, DailyCollection $model)
    {
        return $user->hasPermissionTo('view dailycollections');
    }

    /**
     * Determine whether the dailyCollection can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create dailycollections');
    }

    /**
     * Determine whether the dailyCollection can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailyCollection  $model
     * @return mixed
     */
    public function update(User $user, DailyCollection $model)
    {
        return $user->hasPermissionTo('update dailycollections');
    }

    /**
     * Determine whether the dailyCollection can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailyCollection  $model
     * @return mixed
     */
    public function delete(User $user, DailyCollection $model)
    {
        return $user->hasPermissionTo('delete dailycollections');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailyCollection  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete dailycollections');
    }

    /**
     * Determine whether the dailyCollection can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailyCollection  $model
     * @return mixed
     */
    public function restore(User $user, DailyCollection $model)
    {
        return false;
    }

    /**
     * Determine whether the dailyCollection can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailyCollection  $model
     * @return mixed
     */
    public function forceDelete(User $user, DailyCollection $model)
    {
        return false;
    }
}
