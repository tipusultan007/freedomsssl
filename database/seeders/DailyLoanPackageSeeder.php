<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DailyLoanPackage;

class DailyLoanPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DailyLoanPackage::factory()
            ->count(5)
            ->create();
    }
}
