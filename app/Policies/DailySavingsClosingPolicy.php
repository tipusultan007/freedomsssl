<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DailySavingsClosing;
use Illuminate\Auth\Access\HandlesAuthorization;

class DailySavingsClosingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the dailySavingsClosing can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list dailysavingsclosings');
    }

    /**
     * Determine whether the dailySavingsClosing can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailySavingsClosing  $model
     * @return mixed
     */
    public function view(User $user, DailySavingsClosing $model)
    {
        return $user->hasPermissionTo('view dailysavingsclosings');
    }

    /**
     * Determine whether the dailySavingsClosing can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create dailysavingsclosings');
    }

    /**
     * Determine whether the dailySavingsClosing can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailySavingsClosing  $model
     * @return mixed
     */
    public function update(User $user, DailySavingsClosing $model)
    {
        return $user->hasPermissionTo('update dailysavingsclosings');
    }

    /**
     * Determine whether the dailySavingsClosing can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailySavingsClosing  $model
     * @return mixed
     */
    public function delete(User $user, DailySavingsClosing $model)
    {
        return $user->hasPermissionTo('delete dailysavingsclosings');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailySavingsClosing  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete dailysavingsclosings');
    }

    /**
     * Determine whether the dailySavingsClosing can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailySavingsClosing  $model
     * @return mixed
     */
    public function restore(User $user, DailySavingsClosing $model)
    {
        return false;
    }

    /**
     * Determine whether the dailySavingsClosing can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailySavingsClosing  $model
     * @return mixed
     */
    public function forceDelete(User $user, DailySavingsClosing $model)
    {
        return false;
    }
}
