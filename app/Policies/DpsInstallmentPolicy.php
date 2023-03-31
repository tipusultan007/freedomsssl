<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DpsInstallment;
use Illuminate\Auth\Access\HandlesAuthorization;

class DpsInstallmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the dpsInstallment can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list dpsinstallments');
    }

    /**
     * Determine whether the dpsInstallment can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsInstallment  $model
     * @return mixed
     */
    public function view(User $user, DpsInstallment $model)
    {
        return $user->hasPermissionTo('view dpsinstallments');
    }

    /**
     * Determine whether the dpsInstallment can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create dpsinstallments');
    }

    /**
     * Determine whether the dpsInstallment can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsInstallment  $model
     * @return mixed
     */
    public function update(User $user, DpsInstallment $model)
    {
        return $user->hasPermissionTo('update dpsinstallments');
    }

    /**
     * Determine whether the dpsInstallment can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsInstallment  $model
     * @return mixed
     */
    public function delete(User $user, DpsInstallment $model)
    {
        return $user->hasPermissionTo('delete dpsinstallments');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsInstallment  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete dpsinstallments');
    }

    /**
     * Determine whether the dpsInstallment can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsInstallment  $model
     * @return mixed
     */
    public function restore(User $user, DpsInstallment $model)
    {
        return false;
    }

    /**
     * Determine whether the dpsInstallment can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsInstallment  $model
     * @return mixed
     */
    public function forceDelete(User $user, DpsInstallment $model)
    {
        return false;
    }
}
