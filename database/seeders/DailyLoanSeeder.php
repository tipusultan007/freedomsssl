<?php

namespace Database\Seeders;

use App\Models\DailyLoan;
use Illuminate\Database\Seeder;

class DailyLoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DailyLoan::factory()
            ->count(5)
            ->create();
    }
}
