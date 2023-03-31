<?php

namespace Database\Seeders;

use App\Models\Dps;
use Illuminate\Database\Seeder;

class DpsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Dps::factory()
            ->count(5)
            ->create();
    }
}
