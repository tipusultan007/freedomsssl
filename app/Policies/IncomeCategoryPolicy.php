<?php

namespace App\Policies;

use App\Models\User;
use App\Models\IncomeCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class IncomeCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the incomeCategory can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list incomecategories');
    }

    /**
     * Determine whether the incomeCategory can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\IncomeCategory  $model
     * @return mixed
     */
    public function view(User $user, IncomeCategory $model)
    {
        return $user->hasPermissionTo('view incomecategories');
    }

    /**
     * Determine whether the incomeCategory can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create incomecategories');
    }

    /**
     * Determine whether the incomeCategory can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\IncomeCategory  $model
     * @return mixed
     */
    public function update(User $user, IncomeCategory $model)
    {
        return $user->hasPermissionTo('update incomecategories');
    }

    /**
     * Determine whether the incomeCategory can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\IncomeCategory  $model
     * @return mixed
     */
    public function delete(User $user, IncomeCategory $model)
    {
        return $user->hasPermissionTo('delete incomecategories');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\IncomeCategory  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete incomecategories');
    }

    /**
     * Determine whether the incomeCategory can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\IncomeCategory  $model
     * @return mixed
     */
    public function restore(User $user, IncomeCategory $model)
    {
        return false;
    }

    /**
     * Determine whether the incomeCategory can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\IncomeCategory  $model
     * @return mixed
     */
    public function forceDelete(User $user, IncomeCategory $model)
    {
        return false;
    }
}
