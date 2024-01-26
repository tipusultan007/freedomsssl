<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
  public function run()
  {
    Admin::create([
      'name' => 'Admin User',
      'phone' => '123456789',
      'password' => Hash::make('password'), // Change 'password' to your desired password
    ]);

    // Add more admin users if needed
  }
}
