<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data Dosen Dummy
        $dosens = [
            [
                'name' => 'Dr. Budi Santoso, M.Kom.',
                'nip' => '198001012005011001',
                'email' => 'budi.santoso@example.com',
                'is_asesor' => true,
            ],
            [
                'name' => 'Prof. Dr. Citra Lestari, S.T., M.T.',
                'nip' => '197505052003122001',
                'email' => 'citra.lestari@example.com',
                'is_asesor' => true,
            ],
            [
                'name' => 'Ahmad Subarjo, S.Kom., M.Cs.',
                'nip' => '198503152010011002',
                'email' => 'ahmad.subarjo@example.com',
                'is_asesor' => false,
            ],
        ];

        foreach ($dosens as $dosenData) {
            DB::transaction(function () use ($dosenData) {
                // Buat data di tabel users
                $user = User::create([
                    'name' => $dosenData['name'],
                    'nip' => $dosenData['nip'],
                    'email' => $dosenData['email'],
                    'password' => Hash::make('password'), // password default untuk semua
                ]);

                // Buat data detail di tabel dosen_details
                $user->dosenDetail()->create([
                    'jenis_kelamin' => 'Laki-laki',
                    'tempat_lahir' => 'Surabaya',
                    'tanggal_lahir' => '1980-01-01',
                    'alamat' => 'Jl. Merdeka No. 10, Surabaya',
                    'no_hp' => '081234567890',
                    'status_kepegawaian' => 'PNS',
                    'homebase_prodi' => 'Teknik Informatika',
                    'jabatan_fungsional_saat_ini' => 'Lektor Kepala',
                ]);

                // Tetapkan role 'dosen'
                $user->assignRole('dosen');

                // Jika ditandai, tetapkan juga role 'asesor'
                if ($dosenData['is_asesor']) {
                    $user->assignRole('asesor');
                }
            });
        }
    }
}