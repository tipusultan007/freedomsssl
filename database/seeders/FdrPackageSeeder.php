<?php

namespace Database\Seeders;

use App\Models\FdrPackage;
use Illuminate\Database\Seeder;

class FdrPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FdrPackage::factory()
            ->count(5)
            ->create();
    }
}
