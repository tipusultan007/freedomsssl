<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AdjustAmount;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdjustAmountPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the adjustAmount can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list adjustamounts');
    }

    /**
     * Determine whether the adjustAmount can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AdjustAmount  $model
     * @return mixed
     */
    public function view(User $user, AdjustAmount $model)
    {
        return $user->hasPermissionTo('view adjustamounts');
    }

    /**
     * Determine whether the adjustAmount can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create adjustamounts');
    }

    /**
     * Determine whether the adjustAmount can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AdjustAmount  $model
     * @return mixed
     */
    public function update(User $user, AdjustAmount $model)
    {
        return $user->hasPermissionTo('update adjustamounts');
    }

    /**
     * Determine whether the adjustAmount can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AdjustAmount  $model
     * @return mixed
     */
    public function delete(User $user, AdjustAmount $model)
    {
        return $user->hasPermissionTo('delete adjustamounts');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AdjustAmount  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete adjustamounts');
    }

    /**
     * Determine whether the adjustAmount can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AdjustAmount  $model
     * @return mixed
     */
    public function restore(User $user, AdjustAmount $model)
    {
        return false;
    }

    /**
     * Determine whether the adjustAmount can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AdjustAmount  $model
     * @return mixed
     */
    public function forceDelete(User $user, AdjustAmount $model)
    {
        return false;
    }
}
