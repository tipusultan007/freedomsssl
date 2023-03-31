<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create default permissions
        Permission::create(['name' => 'list addprofits']);
        Permission::create(['name' => 'view addprofits']);
        Permission::create(['name' => 'create addprofits']);
        Permission::create(['name' => 'update addprofits']);
        Permission::create(['name' => 'delete addprofits']);

        Permission::create(['name' => 'list adjustamounts']);
        Permission::create(['name' => 'view adjustamounts']);
        Permission::create(['name' => 'create adjustamounts']);
        Permission::create(['name' => 'update adjustamounts']);
        Permission::create(['name' => 'delete adjustamounts']);

        Permission::create(['name' => 'list cashins']);
        Permission::create(['name' => 'view cashins']);
        Permission::create(['name' => 'create cashins']);
        Permission::create(['name' => 'update cashins']);
        Permission::create(['name' => 'delete cashins']);

        Permission::create(['name' => 'list cashincategories']);
        Permission::create(['name' => 'view cashincategories']);
        Permission::create(['name' => 'create cashincategories']);
        Permission::create(['name' => 'update cashincategories']);
        Permission::create(['name' => 'delete cashincategories']);

        Permission::create(['name' => 'list cashouts']);
        Permission::create(['name' => 'view cashouts']);
        Permission::create(['name' => 'create cashouts']);
        Permission::create(['name' => 'update cashouts']);
        Permission::create(['name' => 'delete cashouts']);

        Permission::create(['name' => 'list cashoutcategories']);
        Permission::create(['name' => 'view cashoutcategories']);
        Permission::create(['name' => 'create cashoutcategories']);
        Permission::create(['name' => 'update cashoutcategories']);
        Permission::create(['name' => 'delete cashoutcategories']);

        Permission::create(['name' => 'list closingaccounts']);
        Permission::create(['name' => 'view closingaccounts']);
        Permission::create(['name' => 'create closingaccounts']);
        Permission::create(['name' => 'update closingaccounts']);
        Permission::create(['name' => 'delete closingaccounts']);

        Permission::create(['name' => 'list dailycollections']);
        Permission::create(['name' => 'view dailycollections']);
        Permission::create(['name' => 'create dailycollections']);
        Permission::create(['name' => 'update dailycollections']);
        Permission::create(['name' => 'delete dailycollections']);

        Permission::create(['name' => 'list dailyloans']);
        Permission::create(['name' => 'view dailyloans']);
        Permission::create(['name' => 'create dailyloans']);
        Permission::create(['name' => 'update dailyloans']);
        Permission::create(['name' => 'delete dailyloans']);

        Permission::create(['name' => 'list dailyloancollections']);
        Permission::create(['name' => 'view dailyloancollections']);
        Permission::create(['name' => 'create dailyloancollections']);
        Permission::create(['name' => 'update dailyloancollections']);
        Permission::create(['name' => 'delete dailyloancollections']);

        Permission::create(['name' => 'list dailyloanpackages']);
        Permission::create(['name' => 'view dailyloanpackages']);
        Permission::create(['name' => 'create dailyloanpackages']);
        Permission::create(['name' => 'update dailyloanpackages']);
        Permission::create(['name' => 'delete dailyloanpackages']);

        Permission::create(['name' => 'list alldailysavings']);
        Permission::create(['name' => 'view alldailysavings']);
        Permission::create(['name' => 'create alldailysavings']);
        Permission::create(['name' => 'update alldailysavings']);
        Permission::create(['name' => 'delete alldailysavings']);

        Permission::create(['name' => 'list dailysavingsclosings']);
        Permission::create(['name' => 'view dailysavingsclosings']);
        Permission::create(['name' => 'create dailysavingsclosings']);
        Permission::create(['name' => 'update dailysavingsclosings']);
        Permission::create(['name' => 'delete dailysavingsclosings']);

        Permission::create(['name' => 'list alldps']);
        Permission::create(['name' => 'view alldps']);
        Permission::create(['name' => 'create alldps']);
        Permission::create(['name' => 'update alldps']);
        Permission::create(['name' => 'delete alldps']);

        Permission::create(['name' => 'list dpscollections']);
        Permission::create(['name' => 'view dpscollections']);
        Permission::create(['name' => 'create dpscollections']);
        Permission::create(['name' => 'update dpscollections']);
        Permission::create(['name' => 'delete dpscollections']);

        Permission::create(['name' => 'list dpsinstallments']);
        Permission::create(['name' => 'view dpsinstallments']);
        Permission::create(['name' => 'create dpsinstallments']);
        Permission::create(['name' => 'update dpsinstallments']);
        Permission::create(['name' => 'delete dpsinstallments']);

        Permission::create(['name' => 'list dpsloans']);
        Permission::create(['name' => 'view dpsloans']);
        Permission::create(['name' => 'create dpsloans']);
        Permission::create(['name' => 'update dpsloans']);
        Permission::create(['name' => 'delete dpsloans']);

        Permission::create(['name' => 'list dpsloancollections']);
        Permission::create(['name' => 'view dpsloancollections']);
        Permission::create(['name' => 'create dpsloancollections']);
        Permission::create(['name' => 'update dpsloancollections']);
        Permission::create(['name' => 'delete dpsloancollections']);

        Permission::create(['name' => 'list dpspackages']);
        Permission::create(['name' => 'view dpspackages']);
        Permission::create(['name' => 'create dpspackages']);
        Permission::create(['name' => 'update dpspackages']);
        Permission::create(['name' => 'delete dpspackages']);

        Permission::create(['name' => 'list dpspackagevalues']);
        Permission::create(['name' => 'view dpspackagevalues']);
        Permission::create(['name' => 'create dpspackagevalues']);
        Permission::create(['name' => 'update dpspackagevalues']);
        Permission::create(['name' => 'delete dpspackagevalues']);

        Permission::create(['name' => 'list expenses']);
        Permission::create(['name' => 'view expenses']);
        Permission::create(['name' => 'create expenses']);
        Permission::create(['name' => 'update expenses']);
        Permission::create(['name' => 'delete expenses']);

        Permission::create(['name' => 'list expensecategories']);
        Permission::create(['name' => 'view expensecategories']);
        Permission::create(['name' => 'create expensecategories']);
        Permission::create(['name' => 'update expensecategories']);
        Permission::create(['name' => 'delete expensecategories']);

        Permission::create(['name' => 'list fdrs']);
        Permission::create(['name' => 'view fdrs']);
        Permission::create(['name' => 'create fdrs']);
        Permission::create(['name' => 'update fdrs']);
        Permission::create(['name' => 'delete fdrs']);

        Permission::create(['name' => 'list fdrdeposits']);
        Permission::create(['name' => 'view fdrdeposits']);
        Permission::create(['name' => 'create fdrdeposits']);
        Permission::create(['name' => 'update fdrdeposits']);
        Permission::create(['name' => 'delete fdrdeposits']);

        Permission::create(['name' => 'list fdrpackages']);
        Permission::create(['name' => 'view fdrpackages']);
        Permission::create(['name' => 'create fdrpackages']);
        Permission::create(['name' => 'update fdrpackages']);
        Permission::create(['name' => 'delete fdrpackages']);

        Permission::create(['name' => 'list fdrpackagevalues']);
        Permission::create(['name' => 'view fdrpackagevalues']);
        Permission::create(['name' => 'create fdrpackagevalues']);
        Permission::create(['name' => 'update fdrpackagevalues']);
        Permission::create(['name' => 'delete fdrpackagevalues']);

        Permission::create(['name' => 'list fdrprofits']);
        Permission::create(['name' => 'view fdrprofits']);
        Permission::create(['name' => 'create fdrprofits']);
        Permission::create(['name' => 'update fdrprofits']);
        Permission::create(['name' => 'delete fdrprofits']);

        Permission::create(['name' => 'list fdrwithdraws']);
        Permission::create(['name' => 'view fdrwithdraws']);
        Permission::create(['name' => 'create fdrwithdraws']);
        Permission::create(['name' => 'update fdrwithdraws']);
        Permission::create(['name' => 'delete fdrwithdraws']);

        Permission::create(['name' => 'list guarantors']);
        Permission::create(['name' => 'view guarantors']);
        Permission::create(['name' => 'create guarantors']);
        Permission::create(['name' => 'update guarantors']);
        Permission::create(['name' => 'delete guarantors']);

        Permission::create(['name' => 'list incomes']);
        Permission::create(['name' => 'view incomes']);
        Permission::create(['name' => 'create incomes']);
        Permission::create(['name' => 'update incomes']);
        Permission::create(['name' => 'delete incomes']);

        Permission::create(['name' => 'list incomecategories']);
        Permission::create(['name' => 'view incomecategories']);
        Permission::create(['name' => 'create incomecategories']);
        Permission::create(['name' => 'update incomecategories']);
        Permission::create(['name' => 'delete incomecategories']);

        Permission::create(['name' => 'list allloandocuments']);
        Permission::create(['name' => 'view allloandocuments']);
        Permission::create(['name' => 'create allloandocuments']);
        Permission::create(['name' => 'update allloandocuments']);
        Permission::create(['name' => 'delete allloandocuments']);

        Permission::create(['name' => 'list allnominees']);
        Permission::create(['name' => 'view allnominees']);
        Permission::create(['name' => 'create allnominees']);
        Permission::create(['name' => 'update allnominees']);
        Permission::create(['name' => 'delete allnominees']);

        Permission::create(['name' => 'list savingscollections']);
        Permission::create(['name' => 'view savingscollections']);
        Permission::create(['name' => 'create savingscollections']);
        Permission::create(['name' => 'update savingscollections']);
        Permission::create(['name' => 'delete savingscollections']);

        Permission::create(['name' => 'list allspecialdps']);
        Permission::create(['name' => 'view allspecialdps']);
        Permission::create(['name' => 'create allspecialdps']);
        Permission::create(['name' => 'update allspecialdps']);
        Permission::create(['name' => 'delete allspecialdps']);

        Permission::create(['name' => 'list specialdpsloans']);
        Permission::create(['name' => 'view specialdpsloans']);
        Permission::create(['name' => 'create specialdpsloans']);
        Permission::create(['name' => 'update specialdpsloans']);
        Permission::create(['name' => 'delete specialdpsloans']);

        Permission::create(['name' => 'list specialdpspackages']);
        Permission::create(['name' => 'view specialdpspackages']);
        Permission::create(['name' => 'create specialdpspackages']);
        Permission::create(['name' => 'update specialdpspackages']);
        Permission::create(['name' => 'delete specialdpspackages']);

        Permission::create(['name' => 'list specialdpspackagevalues']);
        Permission::create(['name' => 'view specialdpspackagevalues']);
        Permission::create(['name' => 'create specialdpspackagevalues']);
        Permission::create(['name' => 'update specialdpspackagevalues']);
        Permission::create(['name' => 'delete specialdpspackagevalues']);

        Permission::create(['name' => 'list specialloantakens']);
        Permission::create(['name' => 'view specialloantakens']);
        Permission::create(['name' => 'create specialloantakens']);
        Permission::create(['name' => 'update specialloantakens']);
        Permission::create(['name' => 'delete specialloantakens']);

        Permission::create(['name' => 'list takenloans']);
        Permission::create(['name' => 'view takenloans']);
        Permission::create(['name' => 'create takenloans']);
        Permission::create(['name' => 'update takenloans']);
        Permission::create(['name' => 'delete takenloans']);

        // Create user role and assign existing permissions
        $currentPermissions = Permission::all();
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo($currentPermissions);

        // Create admin exclusive permissions
        Permission::create(['name' => 'list roles']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'update roles']);
        Permission::create(['name' => 'delete roles']);

        Permission::create(['name' => 'list permissions']);
        Permission::create(['name' => 'view permissions']);
        Permission::create(['name' => 'create permissions']);
        Permission::create(['name' => 'update permissions']);
        Permission::create(['name' => 'delete permissions']);

        Permission::create(['name' => 'list users']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);

        // Create admin role and assign all permissions
        $allPermissions = Permission::all();
        $adminRole = Role::create(['name' => 'super-admin']);
        $adminRole->givePermissionTo($allPermissions);

        $user = \App\Models\User::whereEmail('admin@admin.com')->first();

        if ($user) {
            $user->assignRole($adminRole);
        }
    }
}
