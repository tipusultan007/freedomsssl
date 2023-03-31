<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SpecialDpsLoan;
use Illuminate\Auth\Access\HandlesAuthorization;

class SpecialDpsLoanPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the specialDpsLoan can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list specialdpsloans');
    }

    /**
     * Determine whether the specialDpsLoan can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SpecialDpsLoan  $model
     * @return mixed
     */
    public function view(User $user, SpecialDpsLoan $model)
    {
        return $user->hasPermissionTo('view specialdpsloans');
    }

    /**
     * Determine whether the specialDpsLoan can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create specialdpsloans');
    }

    /**
     * Determine whether the specialDpsLoan can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SpecialDpsLoan  $model
     * @return mixed
     */
    public function update(User $user, SpecialDpsLoan $model)
    {
        return $user->hasPermissionTo('update specialdpsloans');
    }

    /**
     * Determine whether the specialDpsLoan can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SpecialDpsLoan  $model
     * @return mixed
     */
    public function delete(User $user, SpecialDpsLoan $model)
    {
        return $user->hasPermissionTo('delete specialdpsloans');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SpecialDpsLoan  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete specialdpsloans');
    }

    /**
     * Determine whether the specialDpsLoan can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SpecialDpsLoan  $model
     * @return mixed
     */
    public function restore(User $user, SpecialDpsLoan $model)
    {
        return false;
    }

    /**
     * Determine whether the specialDpsLoan can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SpecialDpsLoan  $model
     * @return mixed
     */
    public function forceDelete(User $user, SpecialDpsLoan $model)
    {
        return false;
    }
}
