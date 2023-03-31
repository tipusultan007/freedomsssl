<?php

namespace Database\Seeders;

use App\Models\TakenLoan;
use Illuminate\Database\Seeder;

class TakenLoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TakenLoan::factory()
            ->count(5)
            ->create();
    }
}
