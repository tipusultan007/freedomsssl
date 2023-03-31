<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DailyLoanCollection;

class DailyLoanCollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DailyLoanCollection::factory()
            ->count(5)
            ->create();
    }
}
