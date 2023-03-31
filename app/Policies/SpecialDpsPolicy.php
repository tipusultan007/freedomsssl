<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SpecialDps;
use Illuminate\Auth\Access\HandlesAuthorization;

class SpecialDpsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the specialDps can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list allspecialdps');
    }

    /**
     * Determine whether the specialDps can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SpecialDps  $model
     * @return mixed
     */
    public function view(User $user, SpecialDps $model)
    {
        return $user->hasPermissionTo('view allspecialdps');
    }

    /**
     * Determine whether the specialDps can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create allspecialdps');
    }

    /**
     * Determine whether the specialDps can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SpecialDps  $model
     * @return mixed
     */
    public function update(User $user, SpecialDps $model)
    {
        return $user->hasPermissionTo('update allspecialdps');
    }

    /**
     * Determine whether the specialDps can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SpecialDps  $model
     * @return mixed
     */
    public function delete(User $user, SpecialDps $model)
    {
        return $user->hasPermissionTo('delete allspecialdps');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SpecialDps  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete allspecialdps');
    }

    /**
     * Determine whether the specialDps can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SpecialDps  $model
     * @return mixed
     */
    public function restore(User $user, SpecialDps $model)
    {
        return false;
    }

    /**
     * Determine whether the specialDps can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SpecialDps  $model
     * @return mixed
     */
    public function forceDelete(User $user, SpecialDps $model)
    {
        return false;
    }
}
