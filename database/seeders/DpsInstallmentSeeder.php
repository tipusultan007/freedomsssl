<?php

namespace Database\Seeders;

use App\Models\DpsInstallment;
use Illuminate\Database\Seeder;

class DpsInstallmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DpsInstallment::factory()
            ->count(5)
            ->create();
    }
}
