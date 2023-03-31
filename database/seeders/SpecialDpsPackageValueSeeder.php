<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SpecialDpsPackageValue;

class SpecialDpsPackageValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SpecialDpsPackageValue::factory()
            ->count(5)
            ->create();
    }
}
