<?php

namespace Database\Seeders;

use App\Models\DailySavings;
use Illuminate\Database\Seeder;

class DailySavingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DailySavings::factory()
            ->count(5)
            ->create();
    }
}
