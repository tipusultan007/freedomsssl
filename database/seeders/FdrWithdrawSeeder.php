<?php

namespace Database\Seeders;

use App\Models\FdrWithdraw;
use Illuminate\Database\Seeder;

class FdrWithdrawSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FdrWithdraw::factory()
            ->count(5)
            ->create();
    }
}
