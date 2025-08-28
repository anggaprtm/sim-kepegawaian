<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@sik.com',
            'nip' => '000000000000000000', // NIP unik untuk admin
            'password' => Hash::make('password'),
            'role' => 'superadmin', // Kolom role bawaan
        ]);

        // Tetapkan role melalui Spatie Permission
        $superAdmin->assignRole('superadmin');
    }
}