<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FdrPackageValue;

class FdrPackageValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FdrPackageValue::factory()
            ->count(5)
            ->create();
    }
}
