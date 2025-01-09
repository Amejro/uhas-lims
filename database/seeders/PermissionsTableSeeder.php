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
            // DosageForm
            ['name' => 'DosageForm_access','user_id' => 1],
            ['name' => 'DosageForm_show','user_id' => 1],
            ['name' => 'DosageForm_create','user_id' => 1],
            ['name' => 'DosageForm_edit','user_id' => 1],
            ['name' => 'DosageForm_delete','user_id' => 1],
            // Inventory
            ['name' => 'Inventory_access','user_id' => 1],
            ['name' => 'Inventory_show','user_id' => 1],
            ['name' => 'Inventory_create','user_id' => 1],
            ['name' => 'Inventory_edit','user_id' => 1],
            ['name' => 'Inventory_delete','user_id' => 1],
            //    // Permission
            ['name' => 'Permission_access','user_id' => 1],
            ['name' => 'Permission_show','user_id' => 1],
            ['name' => 'Permission_create','user_id' => 1],
            ['name' => 'Permission_edit','user_id' => 1],
            ['name' => 'Permission_delete','user_id' => 1],
            // Role
            ['name' => 'Role_access','user_id' => 1],
            ['name' => 'Role_show','user_id' => 1],
            ['name' => 'Role_create','user_id' => 1],
            ['name' => 'Role_edit','user_id' => 1],
            ['name' => 'Role_delete','user_id' => 1],
            // User
            ['name' => 'User_access','user_id' => 1],
            ['name' => 'User_show','user_id' => 1],
            ['name' => 'User_create','user_id' => 1],
            ['name' => 'User_edit','user_id' => 1],
            ['name' => 'User_delete','user_id' => 1],
            //Sample
            ['name' => 'Sample_access','user_id' => 1],
            ['name' => 'Sample_show','user_id' => 1],
            ['name' => 'Sample_create','user_id' => 1],
            ['name' => 'Sample_edit','user_id' => 1],
            ['name' => 'Sample_delete','user_id' => 1],
            // SampleTest
            ['name' => 'SampleTest_access','user_id' => 1],
            ['name' => 'SampleTest_show','user_id' => 1],
            ['name' => 'SampleTest_create','user_id' => 1],
            ['name' => 'SampleTest_edit','user_id' => 1],
            ['name' => 'SampleTest_delete','user_id' => 1],
            // Payment
            ['name' => 'Payment_access','user_id' => 1],
            ['name' => 'Payment_show','user_id' => 1],
            ['name' => 'Payment_create','user_id' => 1],
            ['name' => 'Payment_edit','user_id' => 1],
            ['name' => 'Payment_delete','user_id' => 1],
            // PaymentRecord
            ['name' => 'PaymentRecord_access','user_id' => 1],
            ['name' => 'PaymentRecord_show','user_id' => 1],
            ['name' => 'PaymentRecord_create','user_id' => 1],
            ['name' => 'PaymentRecord_edit','user_id' => 1],
            ['name' => 'PaymentRecord_delete','user_id' => 1],
            // Producer
            ['name' => 'Producer_access','user_id' => 1],
            ['name' => 'Producer_show','user_id' => 1],
            ['name' => 'Producer_create','user_id' => 1],
            ['name' => 'Producer_edit','user_id' => 1],
            ['name' => 'Producer_delete','user_id' => 1],
            // StorageLocation
            ['name' => 'StorageLocation_access','user_id' => 1],
            ['name' => 'StorageLocation_show','user_id' => 1],
            ['name' => 'StorageLocation_create','user_id' => 1],
            ['name' => 'StorageLocation_edit','user_id' => 1],
            ['name' => 'StorageLocation_delete','user_id' => 1],
            // Test
            ['name' => 'Test_access','user_id' => 1],
            ['name' => 'Test_show','user_id' => 1],
            ['name' => 'Test_create','user_id' => 1],
            ['name' => 'Test_edit','user_id' => 1],
            ['name' => 'Test_delete','user_id' => 1],
            // Template
            ['name' => 'Template_access','user_id' => 1],
            ['name' => 'Template_show','user_id' => 1],
            ['name' => 'Template_create','user_id' => 1],
            ['name' => 'Template_edit','user_id' => 1],
            ['name' => 'Template_delete','user_id' => 1],
        ];

        Permission::insert($permissions);
    }
}
