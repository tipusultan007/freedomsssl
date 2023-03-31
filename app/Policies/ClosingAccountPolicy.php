<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ClosingAccount;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClosingAccountPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the closingAccount can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list closingaccounts');
    }

    /**
     * Determine whether the closingAccount can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ClosingAccount  $model
     * @return mixed
     */
    public function view(User $user, ClosingAccount $model)
    {
        return $user->hasPermissionTo('view closingaccounts');
    }

    /**
     * Determine whether the closingAccount can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create closingaccounts');
    }

    /**
     * Determine whether the closingAccount can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ClosingAccount  $model
     * @return mixed
     */
    public function update(User $user, ClosingAccount $model)
    {
        return $user->hasPermissionTo('update closingaccounts');
    }

    /**
     * Determine whether the closingAccount can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ClosingAccount  $model
     * @return mixed
     */
    public function delete(User $user, ClosingAccount $model)
    {
        return $user->hasPermissionTo('delete closingaccounts');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ClosingAccount  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete closingaccounts');
    }

    /**
     * Determine whether the closingAccount can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ClosingAccount  $model
     * @return mixed
     */
    public function restore(User $user, ClosingAccount $model)
    {
        return false;
    }

    /**
     * Determine whether the closingAccount can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ClosingAccount  $model
     * @return mixed
     */
    public function forceDelete(User $user, ClosingAccount $model)
    {
        return false;
    }
}
