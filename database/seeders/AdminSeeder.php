<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
{
   User::where('email', 'admin1111@gmail.com')->delete();

User::create([
    'name' => 'Admin',
    'email' => 'admin1111@gmail.com',
    'password' => Hash::make('admin1111'),
]);

}

}