<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'role_name' => 'Admin',
                'description' => 'Full access system',
                'created_at' => now(),
            ],
            [
                'role_name' => 'Operator',
                'description' => 'Limited access',
                'created_at' => now(),
            ],
        ]);
    }
}