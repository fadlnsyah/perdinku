<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Admin', 'username' => 'admin', 'role' => 'ADMIN'],
            ['name' => 'Pegawai', 'username' => 'pegawai', 'role' => 'PEGAWAI'],
            ['name' => 'SDM', 'username' => 'sdm', 'role' => 'SDM'],
        ];

        foreach ($users as $data) {
            $user = User::updateOrCreate(
                ['username' => $data['username']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'status' => 'active',
                ]
            );

            $user->syncRoles([$data['role']]);
        }
    }
}
