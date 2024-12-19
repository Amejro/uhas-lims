<?php

namespace Database\Seeders;

use App\Models\Test;
use App\Models\User;
use App\Models\DosageForm;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);



        DosageForm::insert([
            ['name' => 'Decoction', 'code' => 'DE'],
            ['name' => 'Capsule', 'code' => 'CA'],
            ['name' => 'Cream', 'code' => 'CR'],
            ['name' => 'Ointment', 'code' => 'OI'],
            ['name' => 'Powder', 'code' => 'PO'],
            ['name' => 'Bitters', 'code' => 'BI'],
            ['name' => 'Balm', 'code' => 'BA'],
        ]);


        Test::insert([
            ['name' => 'Pharmacognosy', 'price' => 0, 'description' => '', 'created_by' => 1],
            ['name' => 'Pharmacognosy (with mineral content )', 'description' => '', 'price' => 0, 'created_by' => 1],
            ['name' => 'Microbiology', 'price' => 0, 'description' => '', 'created_by' => 'Eli'],
            ['name' => 'Microbiology (with antimicrobial activity)', 'price' => 0, 'description' => '', 'created_by' => 1],
            ['name' => 'Pharmacology and Toxicology', 'price' => 0, 'description' => '', 'created_by' => 'Eli'],
            ['name' => 'Pharmacology and Toxicology (with sub acute and Bio activity test)', 'price' => 0, 'description' => '', 'created_by' => 'Eli'],
            ['name' => 'Pharmacology and Toxicology (with sub acute)', 'price' => 0, 'description' => '', 'created_by' => 1],
            ['name' => 'Pharmacology and Toxicology (with Bio activity test)', 'price' => 0, 'description' => '', 'created_by' => 1],
        ]);

        Permission::insert([
            // DosageForm
            ['name' => 'DosageForm_access'],
            ['name' => 'DosageForm_show'],
            ['name' => 'DosageForm_create'],
            ['name' => 'DosageForm_edit'],
            ['name' => 'DosageForm_delete'],
            // Inventory
            ['name' => 'Inventory_access'],
            ['name' => 'Inventory_show'],
            ['name' => 'Inventory_create'],
            ['name' => 'Inventory_edit'],
            ['name' => 'Inventory_delete'],
            //    // Permission
            ['name' => 'Permission_access'],
            ['name' => 'Permission_show'],
            ['name' => 'Permission_create'],
            ['name' => 'Permission_edit'],
            ['name' => 'Permission_delete'],
            // Role
            ['name' => 'Role_access'],
            ['name' => 'Role_show'],
            ['name' => 'Role_create'],
            ['name' => 'Role_edit'],
            ['name' => 'Role_delete'],
            // User
            ['name' => 'User_access'],
            ['name' => 'User_show'],
            ['name' => 'User_create'],
            ['name' => 'User_edit'],
            ['name' => 'User_delete'],
            //Sample
            ['name' => 'Sample_access'],
            ['name' => 'Sample_show'],
            ['name' => 'Sample_create'],
            ['name' => 'Sample_edit'],
            ['name' => 'Sample_delete'],
            // SampleTest
            ['name' => 'SampleTest_access'],
            ['name' => 'SampleTest_show'],
            ['name' => 'SampleTest_create'],
            ['name' => 'SampleTest_edit'],
            ['name' => 'SampleTest_delete'],
            // Payment
            ['name' => 'Payment_access'],
            ['name' => 'Payment_show'],
            ['name' => 'Payment_create'],
            ['name' => 'Payment_edit'],
            ['name' => 'Payment_delete'],
            // PaymentRecord
            ['name' => 'PaymentRecord_access'],
            ['name' => 'PaymentRecord_show'],
            ['name' => 'PaymentRecord_create'],
            ['name' => 'PaymentRecord_edit'],
            ['name' => 'PaymentRecord_delete'],
            // Producer
            ['name' => 'Producer_access'],
            ['name' => 'Producer_show'],
            ['name' => 'Producer_create'],
            ['name' => 'Producer_edit'],
            ['name' => 'Producer_delete'],
            // StorageLocation
            ['name' => 'StorageLocation_access'],
            ['name' => 'StorageLocation_show'],
            ['name' => 'StorageLocation_create'],
            ['name' => 'StorageLocation_edit'],
            ['name' => 'StorageLocation_delete'],
            // Test
            ['name' => 'Test_access'],
            ['name' => 'Test_show'],
            ['name' => 'Test_create'],
            ['name' => 'Test_edit'],
            ['name' => 'Test_delete'],
            // Template
            ['name' => 'Template_access'],
            ['name' => 'Template_show'],
            ['name' => 'Template_create'],
            ['name' => 'Template_edit'],
            ['name' => 'Template_delete'],
        ]);
    }
}
