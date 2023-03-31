<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TakenLoan;
use Illuminate\Auth\Access\HandlesAuthorization;

class TakenLoanPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the takenLoan can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list takenloans');
    }

    /**
     * Determine whether the takenLoan can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\TakenLoan  $model
     * @return mixed
     */
    public function view(User $user, TakenLoan $model)
    {
        return $user->hasPermissionTo('view takenloans');
    }

    /**
     * Determine whether the takenLoan can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create takenloans');
    }

    /**
     * Determine whether the takenLoan can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\TakenLoan  $model
     * @return mixed
     */
    public function update(User $user, TakenLoan $model)
    {
        return $user->hasPermissionTo('update takenloans');
    }

    /**
     * Determine whether the takenLoan can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\TakenLoan  $model
     * @return mixed
     */
    public function delete(User $user, TakenLoan $model)
    {
        return $user->hasPermissionTo('delete takenloans');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\TakenLoan  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete takenloans');
    }

    /**
     * Determine whether the takenLoan can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\TakenLoan  $model
     * @return mixed
     */
    public function restore(User $user, TakenLoan $model)
    {
        return false;
    }

    /**
     * Determine whether the takenLoan can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\TakenLoan  $model
     * @return mixed
     */
    public function forceDelete(User $user, TakenLoan $model)
    {
        return false;
    }
}
