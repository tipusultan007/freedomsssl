<?php

namespace Database\Seeders;

use App\Models\DpsLoan;
use Illuminate\Database\Seeder;

class DpsLoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DpsLoan::factory()
            ->count(5)
            ->create();
    }
}
