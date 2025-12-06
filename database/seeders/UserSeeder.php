<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin LiterAsik',
            'email' => 'admin@literasik.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+62 812-3456-7890',
            'address' => 'Jl. Sudirman No. 123, Jakarta Pusat',
            'email_verified_at' => now(),
        ]);

        // Customer Users
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '+62 813-9876-5432',
            'address' => 'Jl. Gatot Subroto No. 45, Jakarta Selatan',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '+62 821-5555-6789',
            'address' => 'Jl. Thamrin No. 78, Jakarta Pusat',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Andi Wijaya',
            'email' => 'andi@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '+62 856-1234-5678',
            'address' => 'Jl. HR Rasuna Said No. 99, Jakarta Selatan',
            'email_verified_at' => now(),
        ]);

        // Buat 10 customer random lagi
        User::factory(10)->create([
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);
    }
}
