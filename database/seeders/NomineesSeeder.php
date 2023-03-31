<?php

namespace Database\Seeders;

use App\Models\Nominees;
use Illuminate\Database\Seeder;

class NomineesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Nominees::factory()
            ->count(5)
            ->create();
    }
}
