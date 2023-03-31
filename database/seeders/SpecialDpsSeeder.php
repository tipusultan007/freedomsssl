<?php

namespace Database\Seeders;

use App\Models\SpecialDps;
use Illuminate\Database\Seeder;

class SpecialDpsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SpecialDps::factory()
            ->count(5)
            ->create();
    }
}
