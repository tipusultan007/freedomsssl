<?php

namespace Database\Seeders;

use App\Models\AddProfit;
use Illuminate\Database\Seeder;

class AddProfitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AddProfit::factory()
            ->count(5)
            ->create();
    }
}
