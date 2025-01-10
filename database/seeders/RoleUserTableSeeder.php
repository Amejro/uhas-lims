<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::findOrFail(1)->role()->sync(1);

        $user = User::findOrFail(1);
        $user->role_id = 1;
        $user->save();


        // User::findOrFail(2)->roles()->sync(2);
    }
}
