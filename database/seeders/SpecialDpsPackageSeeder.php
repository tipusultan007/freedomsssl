<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SpecialDpsPackage;

class SpecialDpsPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SpecialDpsPackage::factory()
            ->count(5)
            ->create();
    }
}
