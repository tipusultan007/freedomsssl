<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CashIn;
use Illuminate\Auth\Access\HandlesAuthorization;

class CashInPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the cashIn can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list cashins');
    }

    /**
     * Determine whether the cashIn can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CashIn  $model
     * @return mixed
     */
    public function view(User $user, CashIn $model)
    {
        return $user->hasPermissionTo('view cashins');
    }

    /**
     * Determine whether the cashIn can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create cashins');
    }

    /**
     * Determine whether the cashIn can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CashIn  $model
     * @return mixed
     */
    public function update(User $user, CashIn $model)
    {
        return $user->hasPermissionTo('update cashins');
    }

    /**
     * Determine whether the cashIn can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CashIn  $model
     * @return mixed
     */
    public function delete(User $user, CashIn $model)
    {
        return $user->hasPermissionTo('delete cashins');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CashIn  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete cashins');
    }

    /**
     * Determine whether the cashIn can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CashIn  $model
     * @return mixed
     */
    public function restore(User $user, CashIn $model)
    {
        return false;
    }

    /**
     * Determine whether the cashIn can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CashIn  $model
     * @return mixed
     */
    public function forceDelete(User $user, CashIn $model)
    {
        return false;
    }
}
