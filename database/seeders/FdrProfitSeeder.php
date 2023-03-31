<?php

namespace Database\Seeders;

use App\Models\FdrProfit;
use Illuminate\Database\Seeder;

class FdrProfitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FdrProfit::factory()
            ->count(5)
            ->create();
    }
}
