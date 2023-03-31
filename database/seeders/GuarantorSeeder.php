<?php

namespace Database\Seeders;

use App\Models\Guarantor;
use Illuminate\Database\Seeder;

class GuarantorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Guarantor::factory()
            ->count(5)
            ->create();
    }
}
