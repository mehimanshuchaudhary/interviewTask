<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = json_decode(file_get_contents(base_path('database/seeders/permissions.json')));
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                [
                    'name'       => $permission->name,
                    'guard_name' => 'web',
                ]
            );
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
