<?php

namespace Database\Seeders;

use App\Models\FdrDeposit;
use Illuminate\Database\Seeder;

class FdrDepositSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FdrDeposit::factory()
            ->count(5)
            ->create();
    }
}
