<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DpsLoanCollection;

class DpsLoanCollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DpsLoanCollection::factory()
            ->count(5)
            ->create();
    }
}
