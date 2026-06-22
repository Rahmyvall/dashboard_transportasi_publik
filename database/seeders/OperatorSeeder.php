<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OperatorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('operators')->insert([
            [
                'operator_name' => 'Default Operator',
                'phone' => '08123456789',
                'email' => 'operator@gmail.com',
                'address' => 'Default Address',
                'status' => 'aktif',
                'created_at' => now(),
            ],
        ]);
    }
}