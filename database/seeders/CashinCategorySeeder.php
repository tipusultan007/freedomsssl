<?php

namespace Database\Seeders;

use App\Models\CashinCategory;
use Illuminate\Database\Seeder;

class CashinCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CashinCategory::factory()
            ->count(5)
            ->create();
    }
}
