<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            DosenSeeder::class,
            // seeder lain bisa ditambahkan di sini
        ]);
    }
}