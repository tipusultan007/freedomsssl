<?php

namespace Database\Seeders;

use App\Models\LoanDocuments;
use Illuminate\Database\Seeder;

class LoanDocumentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LoanDocuments::factory()
            ->count(5)
            ->create();
    }
}
