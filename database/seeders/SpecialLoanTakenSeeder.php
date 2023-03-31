<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SpecialLoanTaken;

class SpecialLoanTakenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SpecialLoanTaken::factory()
            ->count(5)
            ->create();
    }
}
