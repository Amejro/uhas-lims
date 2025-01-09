<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'id' => 1,
                'name' => Role::ROLES['Super_Administrator'],
            ],
            [
                'id' => 2,
                'name' => Role::ROLES['Administrator'],
            ],
        ];

        Role::insert($roles);
    }
}
