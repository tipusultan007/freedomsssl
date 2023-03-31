<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SpecialLoanTaken;
use Illuminate\Auth\Access\HandlesAuthorization;

class SpecialLoanTakenPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the specialLoanTaken can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list specialloantakens');
    }

    /**
     * Determine whether the specialLoanTaken can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SpecialLoanTaken  $model
     * @return mixed
     */
    public function view(User $user, SpecialLoanTaken $model)
    {
        return $user->hasPermissionTo('view specialloantakens');
    }

    /**
     * Determine whether the specialLoanTaken can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create specialloantakens');
    }

    /**
     * Determine whether the specialLoanTaken can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SpecialLoanTaken  $model
     * @return mixed
     */
    public function update(User $user, SpecialLoanTaken $model)
    {
        return $user->hasPermissionTo('update specialloantakens');
    }

    /**
     * Determine whether the specialLoanTaken can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SpecialLoanTaken  $model
     * @return mixed
     */
    public function delete(User $user, SpecialLoanTaken $model)
    {
        return $user->hasPermissionTo('delete specialloantakens');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SpecialLoanTaken  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete specialloantakens');
    }

    /**
     * Determine whether the specialLoanTaken can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SpecialLoanTaken  $model
     * @return mixed
     */
    public function restore(User $user, SpecialLoanTaken $model)
    {
        return false;
    }

    /**
     * Determine whether the specialLoanTaken can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SpecialLoanTaken  $model
     * @return mixed
     */
    public function forceDelete(User $user, SpecialLoanTaken $model)
    {
        return false;
    }
}
