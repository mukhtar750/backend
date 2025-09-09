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
        // User::factory(10)->create();
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(AdminSeeder::class);
        
        // Create BDSP test user
        User::create([
            'name' => 'Test BDSP',
            'email' => 'bdsp@test.com',
            'password' => Hash::make('password'),
            'role' => 'bdsp',
            'is_approved' => true,
        ]);
        
        // Create Entrepreneur test user
        User::create([
            'name' => 'Test Entrepreneur',
            'email' => 'entrepreneur@test.com',
            'password' => Hash::make('password'),
            'role' => 'entrepreneur',
            'is_approved' => true,
            'business_name' => 'Test Business',
            'sector' => 'Technology',
        ]);
        
        // Create Mentor test user
        User::create([
            'name' => 'Test Mentor',
            'email' => 'mentor@test.com',
            'password' => Hash::make('password'),
            'role' => 'bdsp',
            'is_approved' => true,
        ]);
        
        // Create Mentee test user
        User::create([
            'name' => 'Test Mentee',
            'email' => 'mentee@test.com',
            'password' => Hash::make('password'),
            'role' => 'entrepreneur',
            'is_approved' => true,
        ]);
        
        // Seed mentorship forms
        $this->call(MentorshipFormsSeeder::class);

        // Seed categories
        $this->call(CategorySeeder::class);
    }
}
