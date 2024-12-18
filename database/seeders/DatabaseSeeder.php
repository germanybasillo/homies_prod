{{--<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(50)->create();

        \App\Models\User::factory()->create([
            'name' => 'homies',
            'email' => 'homies@admin.com',
            'user_type' => 'admin', // Setting the user_type to 'admin'
            'password' => bcrypt('homies@123'), // Setting a password
        ]);
    }
}--}}
