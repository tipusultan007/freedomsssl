<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AddProfit;
use Illuminate\Auth\Access\HandlesAuthorization;

class AddProfitPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the addProfit can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list addprofits');
    }

    /**
     * Determine whether the addProfit can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AddProfit  $model
     * @return mixed
     */
    public function view(User $user, AddProfit $model)
    {
        return $user->hasPermissionTo('view addprofits');
    }

    /**
     * Determine whether the addProfit can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create addprofits');
    }

    /**
     * Determine whether the addProfit can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AddProfit  $model
     * @return mixed
     */
    public function update(User $user, AddProfit $model)
    {
        return $user->hasPermissionTo('update addprofits');
    }

    /**
     * Determine whether the addProfit can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AddProfit  $model
     * @return mixed
     */
    public function delete(User $user, AddProfit $model)
    {
        return $user->hasPermissionTo('delete addprofits');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AddProfit  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete addprofits');
    }

    /**
     * Determine whether the addProfit can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AddProfit  $model
     * @return mixed
     */
    public function restore(User $user, AddProfit $model)
    {
        return false;
    }

    /**
     * Determine whether the addProfit can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AddProfit  $model
     * @return mixed
     */
    public function forceDelete(User $user, AddProfit $model)
    {
        return false;
    }
}
