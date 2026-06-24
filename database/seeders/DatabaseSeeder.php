<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Admin Toko',
            'email' => 'admin@alkhomart.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Pembeli user
        User::create([
            'name' => 'Pembeli Demo',
            'email' => 'pembeli@alkhomart.com',
            'password' => bcrypt('password'),
            'role' => 'pembeli',
        ]);
    }
}
