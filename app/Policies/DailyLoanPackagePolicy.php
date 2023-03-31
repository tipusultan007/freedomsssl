<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DailyLoanPackage;
use Illuminate\Auth\Access\HandlesAuthorization;

class DailyLoanPackagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the dailyLoanPackage can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list dailyloanpackages');
    }

    /**
     * Determine whether the dailyLoanPackage can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailyLoanPackage  $model
     * @return mixed
     */
    public function view(User $user, DailyLoanPackage $model)
    {
        return $user->hasPermissionTo('view dailyloanpackages');
    }

    /**
     * Determine whether the dailyLoanPackage can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create dailyloanpackages');
    }

    /**
     * Determine whether the dailyLoanPackage can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailyLoanPackage  $model
     * @return mixed
     */
    public function update(User $user, DailyLoanPackage $model)
    {
        return $user->hasPermissionTo('update dailyloanpackages');
    }

    /**
     * Determine whether the dailyLoanPackage can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailyLoanPackage  $model
     * @return mixed
     */
    public function delete(User $user, DailyLoanPackage $model)
    {
        return $user->hasPermissionTo('delete dailyloanpackages');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailyLoanPackage  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete dailyloanpackages');
    }

    /**
     * Determine whether the dailyLoanPackage can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailyLoanPackage  $model
     * @return mixed
     */
    public function restore(User $user, DailyLoanPackage $model)
    {
        return false;
    }

    /**
     * Determine whether the dailyLoanPackage can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailyLoanPackage  $model
     * @return mixed
     */
    public function forceDelete(User $user, DailyLoanPackage $model)
    {
        return false;
    }
}
