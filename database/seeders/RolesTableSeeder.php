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
            // [
            //     'id' => 1,
            //     'name' => Role::ROLES['Super_Administrator'],
            // ],
            // [
            //     'id' => 2,
            //     'name' => Role::ROLES['Administrator'],
            // ],

            ['id' => 1,'name' => 'super Administrator', 'code' => Role::ROLES['super_Administrator'], 'user_id' => 1],
            ['id' => 2,'name' => 'Administrator', 'code' => Role::ROLES['Administrator'], 'user_id' => 1],
            ['id' => 3,'name' => 'Technician', 'code' => Role::ROLES['Technician'], 'user_id' => 1],
            ['id' => 4,'name' => 'Accountant', 'code' => Role::ROLES['Accountant'], 'user_id' => 1],
            ['id' => 5,'name' => 'Receptionist', 'code' => Role::ROLES['Receptionist'], 'user_id' => 1],
            ['id' => 6,'name' => 'Store Keeper', 'code' => Role::ROLES['Store_Keeper'], 'user_id' => 1],
        ];

        Role::insert($roles);
    }
}
