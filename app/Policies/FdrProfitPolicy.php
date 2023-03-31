<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FdrProfit;
use Illuminate\Auth\Access\HandlesAuthorization;

class FdrProfitPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the fdrProfit can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list fdrprofits');
    }

    /**
     * Determine whether the fdrProfit can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FdrProfit  $model
     * @return mixed
     */
    public function view(User $user, FdrProfit $model)
    {
        return $user->hasPermissionTo('view fdrprofits');
    }

    /**
     * Determine whether the fdrProfit can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create fdrprofits');
    }

    /**
     * Determine whether the fdrProfit can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FdrProfit  $model
     * @return mixed
     */
    public function update(User $user, FdrProfit $model)
    {
        return $user->hasPermissionTo('update fdrprofits');
    }

    /**
     * Determine whether the fdrProfit can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FdrProfit  $model
     * @return mixed
     */
    public function delete(User $user, FdrProfit $model)
    {
        return $user->hasPermissionTo('delete fdrprofits');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FdrProfit  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete fdrprofits');
    }

    /**
     * Determine whether the fdrProfit can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FdrProfit  $model
     * @return mixed
     */
    public function restore(User $user, FdrProfit $model)
    {
        return false;
    }

    /**
     * Determine whether the fdrProfit can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FdrProfit  $model
     * @return mixed
     */
    public function forceDelete(User $user, FdrProfit $model)
    {
        return false;
    }
}
