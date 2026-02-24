<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'employees.view',
            'employees.create',
            'employees.update',
            'employees.adjust-balance',
            'vacation-requests.view',
            'vacation-requests.create',
            'vacation-requests.review',
            'vacation-requests.approve',
            'dashboard.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $hrRole = Role::firstOrCreate(['name' => 'hr', 'guard_name' => 'web']);
        $managerRole = Role::firstOrCreate(['name' => 'manager', 'guard_name' => 'web']);

        $adminRole->syncPermissions(Permission::all());

        $hrRole->syncPermissions([
            'employees.view',
            'employees.update',
            'employees.adjust-balance',
            'vacation-requests.view',
            'vacation-requests.review',
            'vacation-requests.approve',
            'dashboard.view',
        ]);

        $managerRole->syncPermissions([
            'employees.view',
            'vacation-requests.view',
            'vacation-requests.review',
            'dashboard.view',
        ]);
    }
}
