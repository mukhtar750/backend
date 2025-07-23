<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Group;

class GroupSeeder extends Seeder
{
    public function run()
    {
        Group::create([
            'name' => 'AWN Hub',
            'slug' => 'awn-hub',
            'description' => 'Global community chat for all users',
            'is_global' => true,
        ]);
    }
}