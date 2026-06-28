<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            OperatorSeeder::class,
        ]);

        $role = DB::table('roles')
            ->where('role_name', 'Admin')
            ->first();

        $operator = DB::table('operators')->first();

        if (!$role || !$operator) {
            dd('ROLE ATAU OPERATOR KOSONG', [
                'roles' => DB::table('roles')->get(),
                'operators' => DB::table('operators')->get(),
            ]);
        }

        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'role_id' => $role->id,
                'operator_id' => $operator->id,

                'name' => 'Admin System',
                'email' => 'admin@gmail.com',

                'password' => Hash::make('admin123'),
                'status' => 'aktif',
            ]
        );
    }
}