<?php

namespace Database\Seeders;

use App\Models\DpsPackage;
use Illuminate\Database\Seeder;

class DpsPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DpsPackage::factory()
            ->count(5)
            ->create();
    }
}
