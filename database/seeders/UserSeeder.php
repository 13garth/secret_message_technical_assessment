<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'id' => '1',
                'name' => 'Tom',
                'email' => 'tom@gmail.com',
                'password' => 'Pass#123',
                'role' => 'Admin',
            ],
            [
                'id' => '2',
                'name' => 'Jerry',
                'email' => 'jerry@gmail.com',
                'password' => 'Pass#123',
                'role' => 'User',
            ]
        ];

        foreach ($users as $user) {
            User::firstOrCreate(['id' => $user['id']], [
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
                'role' => $user['role'],
            ]);
        }
    }
}
