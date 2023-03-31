<?php

namespace Database\Seeders;

use App\Models\CashIn;
use Illuminate\Database\Seeder;

class CashInSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CashIn::factory()
            ->count(5)
            ->create();
    }
}
