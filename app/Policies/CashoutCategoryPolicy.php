<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CashoutCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class CashoutCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the cashoutCategory can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list cashoutcategories');
    }

    /**
     * Determine whether the cashoutCategory can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CashoutCategory  $model
     * @return mixed
     */
    public function view(User $user, CashoutCategory $model)
    {
        return $user->hasPermissionTo('view cashoutcategories');
    }

    /**
     * Determine whether the cashoutCategory can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create cashoutcategories');
    }

    /**
     * Determine whether the cashoutCategory can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CashoutCategory  $model
     * @return mixed
     */
    public function update(User $user, CashoutCategory $model)
    {
        return $user->hasPermissionTo('update cashoutcategories');
    }

    /**
     * Determine whether the cashoutCategory can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CashoutCategory  $model
     * @return mixed
     */
    public function delete(User $user, CashoutCategory $model)
    {
        return $user->hasPermissionTo('delete cashoutcategories');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CashoutCategory  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete cashoutcategories');
    }

    /**
     * Determine whether the cashoutCategory can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CashoutCategory  $model
     * @return mixed
     */
    public function restore(User $user, CashoutCategory $model)
    {
        return false;
    }

    /**
     * Determine whether the cashoutCategory can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CashoutCategory  $model
     * @return mixed
     */
    public function forceDelete(User $user, CashoutCategory $model)
    {
        return false;
    }
}
