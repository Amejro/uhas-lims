<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Emmanuel Essiaw',
                'email' => 'emma@gmail.com',
                'password' => bcrypt('admin'),
                'remember_token' => null,
            ],
            [
                'name' => 'Kwau Essi',
                'email' => 'kwaku@gmail.com',
                'password' => bcrypt('password'),
                'remember_token' => null,
            ],
        ];

        User::insert($users);
    }
}
