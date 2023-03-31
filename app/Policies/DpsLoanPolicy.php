<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DpsLoan;
use Illuminate\Auth\Access\HandlesAuthorization;

class DpsLoanPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the dpsLoan can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list dpsloans');
    }

    /**
     * Determine whether the dpsLoan can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsLoan  $model
     * @return mixed
     */
    public function view(User $user, DpsLoan $model)
    {
        return $user->hasPermissionTo('view dpsloans');
    }

    /**
     * Determine whether the dpsLoan can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create dpsloans');
    }

    /**
     * Determine whether the dpsLoan can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsLoan  $model
     * @return mixed
     */
    public function update(User $user, DpsLoan $model)
    {
        return $user->hasPermissionTo('update dpsloans');
    }

    /**
     * Determine whether the dpsLoan can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsLoan  $model
     * @return mixed
     */
    public function delete(User $user, DpsLoan $model)
    {
        return $user->hasPermissionTo('delete dpsloans');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsLoan  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete dpsloans');
    }

    /**
     * Determine whether the dpsLoan can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsLoan  $model
     * @return mixed
     */
    public function restore(User $user, DpsLoan $model)
    {
        return false;
    }

    /**
     * Determine whether the dpsLoan can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsLoan  $model
     * @return mixed
     */
    public function forceDelete(User $user, DpsLoan $model)
    {
        return false;
    }
}
