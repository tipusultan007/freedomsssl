<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DailyCollection;

class DailyCollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DailyCollection::factory()
            ->count(5)
            ->create();
    }
}
