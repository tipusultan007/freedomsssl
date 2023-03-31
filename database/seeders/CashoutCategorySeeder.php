<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CashoutCategory;

class CashoutCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CashoutCategory::factory()
            ->count(5)
            ->create();
    }
}
