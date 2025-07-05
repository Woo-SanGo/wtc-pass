<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::updateOrCreate(
        ['email' => 'admin168@gmail.com'],
        [
            'name' => 'Admin',
            'email' => 'admin168@gmail.com',
            'password' => Hash::make('admin168'),
            'role' => 'admin'  // <-- if you use a role column
        ]
    );

        // Call ShelterApplicationSeeder
        $this->call(ShelterApplicationSeeder::class);
    }
}
