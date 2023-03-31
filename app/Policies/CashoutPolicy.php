<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Cashout;
use Illuminate\Auth\Access\HandlesAuthorization;

class CashoutPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the cashout can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list cashouts');
    }

    /**
     * Determine whether the cashout can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Cashout  $model
     * @return mixed
     */
    public function view(User $user, Cashout $model)
    {
        return $user->hasPermissionTo('view cashouts');
    }

    /**
     * Determine whether the cashout can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create cashouts');
    }

    /**
     * Determine whether the cashout can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Cashout  $model
     * @return mixed
     */
    public function update(User $user, Cashout $model)
    {
        return $user->hasPermissionTo('update cashouts');
    }

    /**
     * Determine whether the cashout can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Cashout  $model
     * @return mixed
     */
    public function delete(User $user, Cashout $model)
    {
        return $user->hasPermissionTo('delete cashouts');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Cashout  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete cashouts');
    }

    /**
     * Determine whether the cashout can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Cashout  $model
     * @return mixed
     */
    public function restore(User $user, Cashout $model)
    {
        return false;
    }

    /**
     * Determine whether the cashout can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Cashout  $model
     * @return mixed
     */
    public function forceDelete(User $user, Cashout $model)
    {
        return false;
    }
}
