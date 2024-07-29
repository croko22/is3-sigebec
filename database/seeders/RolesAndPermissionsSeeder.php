<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Permission::create(['name' => 'create scholarship']);
        Permission::create(['name' => 'edit scholarship']);
        Permission::create(['name' => 'delete scholarship']);
        Permission::create(['name' => 'view scholarship']);

        Permission::create(['name' => 'create student']);
        Permission::create(['name' => 'edit student']);
        Permission::create(['name' => 'delete student']);
        Permission::create(['name' => 'view student']);

        Permission::create(['name' => 'create applicant']);
        Permission::create(['name' => 'edit applicant']);
        Permission::create(['name' => 'delete applicant']);
        Permission::create(['name' => 'view applicant']);

        Permission::create(['name' => 'take attendance']);

        $applicantRole = Role::create(['name' => 'applicant']);
        $applicantRole->givePermissionTo(['take attendance']);

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'create scholarship',
            'edit scholarship',
            'delete scholarship',
            'view scholarship',
            'create student',
            'edit student',
            'delete student',
            'view student',
            'create applicant',
            'edit applicant',
            'delete applicant',
            'view applicant',
        ]);

    }
}
