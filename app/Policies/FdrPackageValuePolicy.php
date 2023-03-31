<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FdrPackageValue;
use Illuminate\Auth\Access\HandlesAuthorization;

class FdrPackageValuePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the fdrPackageValue can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list fdrpackagevalues');
    }

    /**
     * Determine whether the fdrPackageValue can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FdrPackageValue  $model
     * @return mixed
     */
    public function view(User $user, FdrPackageValue $model)
    {
        return $user->hasPermissionTo('view fdrpackagevalues');
    }

    /**
     * Determine whether the fdrPackageValue can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create fdrpackagevalues');
    }

    /**
     * Determine whether the fdrPackageValue can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FdrPackageValue  $model
     * @return mixed
     */
    public function update(User $user, FdrPackageValue $model)
    {
        return $user->hasPermissionTo('update fdrpackagevalues');
    }

    /**
     * Determine whether the fdrPackageValue can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FdrPackageValue  $model
     * @return mixed
     */
    public function delete(User $user, FdrPackageValue $model)
    {
        return $user->hasPermissionTo('delete fdrpackagevalues');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FdrPackageValue  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete fdrpackagevalues');
    }

    /**
     * Determine whether the fdrPackageValue can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FdrPackageValue  $model
     * @return mixed
     */
    public function restore(User $user, FdrPackageValue $model)
    {
        return false;
    }

    /**
     * Determine whether the fdrPackageValue can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FdrPackageValue  $model
     * @return mixed
     */
    public function forceDelete(User $user, FdrPackageValue $model)
    {
        return false;
    }
}
