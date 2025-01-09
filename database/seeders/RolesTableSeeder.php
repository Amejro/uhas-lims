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

            ['id' => 1,'name' => 'Super Admin', 'code' => 'super_admin', 'user_id' => 1],
            ['id' => 2,'name' => 'Admin', 'code' => 'admin', 'user_id' => 1],
            ['id' => 3,'name' => 'Technician', 'code' => 'technician', 'user_id' => 1],
            ['id' => 4,'name' => 'Accountant', 'code' => 'accountant', 'user_id' => 1],
            ['id' => 5,'name' => 'Receptionist', 'code' => 'receptionist', 'user_id' => 1],
            ['id' => 6,'name' => 'Store Keeper', 'code' => 'store_keeper', 'user_id' => 1],
        ];

        Role::insert($roles);
    }
}
