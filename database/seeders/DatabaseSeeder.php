<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BookSeeder::class,
            UserSeeder::class,
            BookReviewSeeder::class,
            OrderFactorySeeder::class,
            CartCheckoutSeeder::class,
        ]);

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('📧 Admin Email: admin@literasik.com');
        $this->command->info('🔑 Password: password');
        $this->command->newLine();
        $this->command->info('📧 Customer Email: budi@example.com');
        $this->command->info('🔑 Password: password');
    }
}
