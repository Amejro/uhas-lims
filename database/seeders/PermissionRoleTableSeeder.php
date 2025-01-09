<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\AdminPermissionsTableSeeder;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $super_admin_permissions = Permission::all();

        // $admin_permissions =Permission::whereIn('name', [
        // 'DosageForm_access',
        // 'DosageForm_show',
        // 'DosageForm_create',
        // 'DosageForm_edit',
        // 'DosageForm_delete',

        // 'Inventory_access',
        // 'Inventory_show',
        // 'Inventory_create',
        // 'Inventory_edit',
        // 'Inventory_delete',

        // 'User_access',
        // 'User_show',
        // 'User_create',
        // 'User_edit',

        // 'Sample_access',
        // 'Sample_show',
        // 'Sample_create',
        // 'Sample_edit',
        // 'Sample_delete',

        // 'SampleTest_access',
        // 'department_access',
        // 'discontinue_create',
        // 'discontinue_edit',
        // 'discontinue_show',
        // 'discontinue_access',
        // 'profile_create',
        // 'profile_edit',
        // 'profile_show',
        // 'profile_access',
        // 'research_create',
        // 'research_edit',
        // 'research_show',
        // 'research_access',
        // 'resubmission_create',
        // 'resubmission_edit',
        // 'resubmission_show',
        // 'resubmission_access',
        // 'school_create',
        // 'school_edit',
        // 'school_show',
        // 'school_access',
        // 'studentsupervisor_create',
        // 'studentsupervisor_edit',
        // 'studentsupervisor_show',
        // 'studentsupervisor_access'
        // ])->get();


        Role::findOrFail(1)->permissions()->sync($super_admin_permissions);
        // Role::findOrFail(2)->permissions()->sync($admin_permissions);
    }
}
