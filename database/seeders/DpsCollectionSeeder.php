<?php

namespace Database\Seeders;

use App\Models\DpsCollection;
use Illuminate\Database\Seeder;

class DpsCollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DpsCollection::factory()
            ->count(5)
            ->create();
    }
}
