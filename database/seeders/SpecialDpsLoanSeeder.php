<?php

namespace Database\Seeders;

use App\Models\SpecialDpsLoan;
use Illuminate\Database\Seeder;

class SpecialDpsLoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SpecialDpsLoan::factory()
            ->count(5)
            ->create();
    }
}
