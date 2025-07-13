<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test users for different roles
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@test.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_approved' => true,
            ],
            [
                'name' => 'John Investor',
                'email' => 'investor@test.com',
                'password' => Hash::make('password'),
                'role' => 'investor',
                'is_approved' => true,
                'phone' => '+2348012345678',
                'type_of_investor' => 'Angel Investor',
                'interest_areas' => 'Technology, Healthcare',
                'company' => 'Tech Ventures Ltd',
                'investor_linkedin' => 'https://linkedin.com/in/johninvestor',
            ],
            [
                'name' => 'Sarah BDSP',
                'email' => 'bdsp@test.com',
                'password' => Hash::make('password'),
                'role' => 'bdsp',
                'is_approved' => true,
                'services_provided' => 'Business Development, Strategy',
                'years_of_experience' => '5',
                'organization' => 'Business Solutions Inc',
                'certifications' => 'Certified Business Consultant',
                'bdsp_linkedin' => 'https://linkedin.com/in/sarahbdsp',
            ],
            [
                'name' => 'Mike Entrepreneur',
                'email' => 'entrepreneur@test.com',
                'password' => Hash::make('password'),
                'role' => 'entrepreneur',
                'is_approved' => true,
                'business_name' => 'Innovation Startup',
                'sector' => 'Technology',
                'cac_number' => 'RC123456',
                'funding_stage' => 'Seed',
                'website' => 'https://innovationstartup.com',
                'entrepreneur_phone' => '+2348098765432',
                'entrepreneur_linkedin' => 'https://linkedin.com/in/mikeentrepreneur',
            ],
            [
                'name' => 'Lisa Mentor',
                'email' => 'mentor@test.com',
                'password' => Hash::make('password'),
                'role' => 'mentor',
                'is_approved' => true,
            ],
            [
                'name' => 'David Mentee',
                'email' => 'mentee@test.com',
                'password' => Hash::make('password'),
                'role' => 'mentee',
                'is_approved' => true,
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

        $this->command->info('Test users created successfully!');
        $this->command->info('Admin: admin@test.com / password');
        $this->command->info('Investor: investor@test.com / password');
        $this->command->info('BDSP: bdsp@test.com / password');
        $this->command->info('Entrepreneur: entrepreneur@test.com / password');
        $this->command->info('Mentor: mentor@test.com / password');
        $this->command->info('Mentee: mentee@test.com / password');
    }
}
