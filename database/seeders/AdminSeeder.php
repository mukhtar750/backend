<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $admin = User::where('role', 'admin')->first();
        if (!$admin) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_approved' => 1,
            ]);
        } else {
            $admin->update(['is_approved' => 1]);
        }
    }
}
