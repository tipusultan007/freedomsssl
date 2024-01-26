<?php

namespace Database\Seeders;

use App\Models\Manager;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ManagerSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $managers = [
      ['id' => 1, 'name' => 'Rubel Dey', 'phone' => '01852173672', 'password' => Hash::make('password1')],
      ['id' => 2, 'name' => 'JHONTU NATH', 'phone' => '01858931047', 'password' => Hash::make('password2')],
      ['id' => 3, 'name' => 'OFFICE', 'phone' => '01880956661', 'password' => Hash::make('password3')],
      ['id' => 4, 'name' => 'BAISHAKI AICH', 'phone' => '01776839066', 'password' => Hash::make('password4')],
      ['id' => 5, 'name' => 'RAJIB NATH', 'phone' => '01825828231', 'password' => Hash::make('password5')],
      ['id' => 6, 'name' => 'DINER KANTI DAS', 'phone' => '01812568137', 'password' => Hash::make('password6')],
      ['id' => 7, 'name' => 'SUMAN SEN', 'phone' => '01812203528', 'password' => Hash::make('password7')],
      ['id' => 8, 'name' => 'RONY CHOWDHURY', 'phone' => '01815330078', 'password' => Hash::make('password8')],
      ['id' => 9, 'name' => 'SUDWIP DUTTA JIMI', 'phone' => '01825551141', 'password' => Hash::make('password9')],
      ['id' => 10, 'name' => 'SAJIB DEY', 'phone' => '01830069938', 'password' => Hash::make('password10')],
      ['id' => 11, 'name' => 'PALASH DATTA', 'phone' => '01914219279', 'password' => Hash::make('password11')],
    ];

    DB::table('managers')->insert($managers);
  }
}
