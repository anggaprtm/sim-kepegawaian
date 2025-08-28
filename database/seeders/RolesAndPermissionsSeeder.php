<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat Role
        Role::create(['name' => 'superadmin']);
        Role::create(['name' => 'dosen']);
        Role::create(['name' => 'tendik']);
        Role::create(['name' => 'asesor']);

        // Contoh pembuatan permission (opsional untuk sekarang, tapi bagus untuk masa depan)
        // Permission::create(['name' => 'manage users']);
        // Role::findByName('superadmin')->givePermissionTo('manage users');
    }
}
