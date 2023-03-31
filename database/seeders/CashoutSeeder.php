<?php

namespace Database\Seeders;

use App\Models\Cashout;
use Illuminate\Database\Seeder;

class CashoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cashout::factory()
            ->count(5)
            ->create();
    }
}
