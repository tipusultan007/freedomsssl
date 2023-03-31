<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DpsPackageValue;

class DpsPackageValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DpsPackageValue::factory()
            ->count(5)
            ->create();
    }
}
