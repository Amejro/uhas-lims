<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Permission::whereIn('name', [
        'attachment_create',
        'attachment_edit',
        'attachment_show',
        'attachment_access',
        'bank_create',
        'bank_edit',
        'bank_show',
        'bank_access',
        'user_create',
        'user_edit',
        'user_show',
        'user_access',
        'checks_create',
        'checks_edit',
        'checks_show',
        'checks_access',
        'department_create',
        'department_edit',
        'department_show',
        'department_access',
        'discontinue_create',
        'discontinue_edit',
        'discontinue_show',
        'discontinue_access',
        'profile_create',
        'profile_edit',
        'profile_show',
        'profile_access',
        'research_create',
        'research_edit',
        'research_show',
        'research_access',
        'resubmission_create',
        'resubmission_edit',
        'resubmission_show',
        'resubmission_access',
        'school_create',
        'school_edit',
        'school_show',
        'school_access',
        'studentsupervisor_create',
        'studentsupervisor_edit',
        'studentsupervisor_show',
        'studentsupervisor_access'
        ])->get();





    }
}
