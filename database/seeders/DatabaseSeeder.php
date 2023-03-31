<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'email' => 'admin@admin.com',
                'password' => \Hash::make('admin'),
            ]);
        $this->call(PermissionsSeeder::class);

       /* $this->call(AddProfitSeeder::class);
        $this->call(AdjustAmountSeeder::class);
        $this->call(CashInSeeder::class);
        $this->call(CashinCategorySeeder::class);
        $this->call(CashoutSeeder::class);
        $this->call(CashoutCategorySeeder::class);
        $this->call(ClosingAccountSeeder::class);
        $this->call(DailyCollectionSeeder::class);
        $this->call(DailyLoanSeeder::class);
        $this->call(DailyLoanCollectionSeeder::class);
        $this->call(DailyLoanPackageSeeder::class);
        $this->call(DailySavingsSeeder::class);
        $this->call(DailySavingsClosingSeeder::class);
        $this->call(DpsSeeder::class);
        $this->call(DpsCollectionSeeder::class);
        $this->call(DpsInstallmentSeeder::class);
        $this->call(DpsLoanSeeder::class);
        $this->call(DpsLoanCollectionSeeder::class);
        $this->call(DpsPackageSeeder::class);
        $this->call(DpsPackageValueSeeder::class);
        $this->call(ExpenseSeeder::class);
        $this->call(ExpenseCategorySeeder::class);
        $this->call(FdrSeeder::class);
        $this->call(FdrDepositSeeder::class);
        $this->call(FdrPackageSeeder::class);
        $this->call(FdrPackageValueSeeder::class);
        $this->call(FdrProfitSeeder::class);
        $this->call(FdrWithdrawSeeder::class);
        $this->call(GuarantorSeeder::class);
        $this->call(IncomeSeeder::class);
        $this->call(IncomeCategorySeeder::class);
        $this->call(LoanDocumentsSeeder::class);
        $this->call(NomineesSeeder::class);
        $this->call(SavingsCollectionSeeder::class);
        $this->call(SpecialDpsSeeder::class);
        $this->call(SpecialDpsLoanSeeder::class);
        $this->call(SpecialDpsPackageSeeder::class);
        $this->call(SpecialDpsPackageValueSeeder::class);
        $this->call(SpecialLoanTakenSeeder::class);
        $this->call(TakenLoanSeeder::class);
        $this->call(UserSeeder::class);*/
    }
}
