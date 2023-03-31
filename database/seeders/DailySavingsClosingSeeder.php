<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DailySavingsClosing;

class DailySavingsClosingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DailySavingsClosing::factory()
            ->count(5)
            ->create();
    }
}
