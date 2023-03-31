<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Guarantor;
use Illuminate\Auth\Access\HandlesAuthorization;

class GuarantorPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the guarantor can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list guarantors');
    }

    /**
     * Determine whether the guarantor can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Guarantor  $model
     * @return mixed
     */
    public function view(User $user, Guarantor $model)
    {
        return $user->hasPermissionTo('view guarantors');
    }

    /**
     * Determine whether the guarantor can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create guarantors');
    }

    /**
     * Determine whether the guarantor can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Guarantor  $model
     * @return mixed
     */
    public function update(User $user, Guarantor $model)
    {
        return $user->hasPermissionTo('update guarantors');
    }

    /**
     * Determine whether the guarantor can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Guarantor  $model
     * @return mixed
     */
    public function delete(User $user, Guarantor $model)
    {
        return $user->hasPermissionTo('delete guarantors');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Guarantor  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete guarantors');
    }

    /**
     * Determine whether the guarantor can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Guarantor  $model
     * @return mixed
     */
    public function restore(User $user, Guarantor $model)
    {
        return false;
    }

    /**
     * Determine whether the guarantor can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Guarantor  $model
     * @return mixed
     */
    public function forceDelete(User $user, Guarantor $model)
    {
        return false;
    }
}
