<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'name' => 'permission_create',
            ],
            [
                'name' => 'permission_edit',
            ],
            [
                'name' => 'permission_delete',
            ],
            [
                'name' => 'permission_show',
            ],
            [
                'name' => 'permission_access',
            ],
            [
                'name' => 'role_create',
            ],
            [
                'name' => 'role_edit',
            ],
            [
                'name' => 'role_show',
            ],
            [
                'name' => 'role_delete',
            ],
            [
                'name' => 'role_access',
            ],
            [
                'name' => 'attachment_create',
            ],
            [
                'name' => 'attachment_edit',
            ],
            [
                'name' => 'attachment_show',
            ],
            [
                'name' => 'attachment_delete',
            ],
            [
                'name' => 'attachment_access',
            ],
            [
                'name' => 'bank_create',
            ],
            [
                'name' => 'bank_edit',
            ],
            [
                'name' => 'bank_show',
            ],
            [
                'name' => 'bank_delete',
            ],
            [
                'name' => 'bank_access',
            ],
            [
                'name' => 'user_create',
            ],
            [
                'name' => 'user_edit',
            ],
            [
                'name' => 'user_show',
            ],
            [
                'name' => 'user_delete',
            ],
            [
                'name' => 'user_access',
            ],
            [
                'name' => 'checks_create',
            ],
            [
                'name' => 'checks_edit',
            ],
            [
                'name' => 'checks_show',
            ],
            [
                'name' => 'checks_delete',
            ],
            [
                'name' => 'checks_access',
            ],
            [
                'name' => 'department_create',
            ],
            [
                'name' => 'department_edit',
            ],
            [
                'name' => 'department_show',
            ],
            [
                'name' => 'department_delete',
            ],
            [
                'name' => 'department_access',
            ],
            [
                'name' => 'discontinue_create',
            ],
            [
                'name' => 'discontinue_edit',
            ],
            [
                'name' => 'discontinue_show',
            ],
            [
                'name' => 'discontinue_delete',
            ],
            [
                'name' => 'discontinue_access',
            ],
            [
                'name' => 'profile_create',
            ],
            [
                'name' => 'profile_edit',
            ],
            [
                'name' => 'profile_show',
            ],
            [
                'name' => 'profile_delete',
            ],
            [
                'name' => 'profile_access',
            ],
            [
                'name' => 'research_create',
            ],
            [
                'name' => 'research_edit',
            ],
            [
                'name' => 'research_show',
            ],
            [
                'name' => 'research_delete',
            ],
            [
                'name' => 'research_access',
            ],
            [
                'name' => 'resubmission_create',
            ],
            [
                'name' => 'resubmission_edit',
            ],
            [
                'name' => 'resubmission_show',
            ],
            [
                'name' => 'resubmission_delete',
            ],
            [
                'name' => 'resubmission_access',
            ],
            [
                'name' => 'school_create',
            ],
            [
                'name' => 'school_edit',
            ],
            [
                'name' => 'school_show',
            ],
            [
                'name' => 'school_delete',
            ],
            [
                'name' => 'school_access',
            ],
            [
                'name' => 'studentsupervisor_create',
            ],
            [
                'name' => 'studentsupervisor_edit',
            ],
            [
                'name' => 'studentsupervisor_show',
            ],
            [
                'name' => 'studentsupervisor_delete',
            ],
            [
                'name' => 'studentsupervisor_access',
            ],
        ];

        Permission::insert($permissions);
    }
}
