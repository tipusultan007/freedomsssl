<?php

namespace Database\Seeders;

use App\Models\Fdr;
use Illuminate\Database\Seeder;

class FdrSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Fdr::factory()
            ->count(5)
            ->create();
    }
}
