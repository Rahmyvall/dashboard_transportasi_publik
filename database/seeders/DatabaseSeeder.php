<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // jalankan master data dulu
        $this->call([
            RoleSeeder::class,
            OperatorSeeder::class,
        ]);

        // pastikan user admin selalu bersih (anti duplicate)
        User::updateOrCreate(
            [
                'username' => 'admin'
            ],
            [
                'role_id' => 1,
                'operator_id' => 1,

                'name' => 'Admin System',
                'email' => 'admin@gmail.com',

                // FIX PENTING: password harus hash
                'password' => Hash::make('admin123'),

                'status' => 'aktif',
            ]
        );
    }
}