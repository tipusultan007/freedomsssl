<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CashinCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class CashinCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the cashinCategory can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list cashincategories');
    }

    /**
     * Determine whether the cashinCategory can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CashinCategory  $model
     * @return mixed
     */
    public function view(User $user, CashinCategory $model)
    {
        return $user->hasPermissionTo('view cashincategories');
    }

    /**
     * Determine whether the cashinCategory can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create cashincategories');
    }

    /**
     * Determine whether the cashinCategory can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CashinCategory  $model
     * @return mixed
     */
    public function update(User $user, CashinCategory $model)
    {
        return $user->hasPermissionTo('update cashincategories');
    }

    /**
     * Determine whether the cashinCategory can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CashinCategory  $model
     * @return mixed
     */
    public function delete(User $user, CashinCategory $model)
    {
        return $user->hasPermissionTo('delete cashincategories');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CashinCategory  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete cashincategories');
    }

    /**
     * Determine whether the cashinCategory can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CashinCategory  $model
     * @return mixed
     */
    public function restore(User $user, CashinCategory $model)
    {
        return false;
    }

    /**
     * Determine whether the cashinCategory can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CashinCategory  $model
     * @return mixed
     */
    public function forceDelete(User $user, CashinCategory $model)
    {
        return false;
    }
}
