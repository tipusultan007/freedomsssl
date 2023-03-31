<?php

namespace Database\Seeders;

use App\Models\AdjustAmount;
use Illuminate\Database\Seeder;

class AdjustAmountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdjustAmount::factory()
            ->count(5)
            ->create();
    }
}
