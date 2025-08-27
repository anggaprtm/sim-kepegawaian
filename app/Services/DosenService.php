<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DosenService
{
    public function getAllDosen()
    {
        return User::where('role', 'dosen')->with('dosenDetail')->latest()->get();
    }

    public function storeDosen(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'nip' => $data['nip'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'dosen',
            ]);

            $user->dosenDetail()->create([
                'jenis_kelamin' => $data['jenis_kelamin'],
                'tempat_lahir' => $data['tempat_lahir'],
                'tanggal_lahir' => $data['tanggal_lahir'],
                'alamat' => $data['alamat'],
                'no_hp' => $data['no_hp'],
                'status_kepegawaian' => $data['status_kepegawaian'],
                'homebase_prodi' => $data['homebase_prodi'],
                'jabatan_fungsional_saat_ini' => $data['jabatan_fungsional_saat_ini'],
            ]);

            $user->assignRole('dosen');

            return $user;
        });
    }

    public function updateDosen(User $dosen, array $data): User
    {
        return DB::transaction(function () use ($dosen, $data) {
            $dosen->update([
                'name' => $data['name'],
                'nip' => $data['nip'],
                'email' => $data['email'],
            ]);

            if (!empty($data['password'])) {
                $dosen->update(['password' => Hash::make($data['password'])]);
            }

            $dosen->dosenDetail()->update([
                'jenis_kelamin' => $data['jenis_kelamin'],
                'tempat_lahir' => $data['tempat_lahir'],
                'tanggal_lahir' => $data['tanggal_lahir'],
                'alamat' => $data['alamat'],
                'no_hp' => $data['no_hp'],
                'status_kepegawaian' => $data['status_kepegawaian'],
                'homebase_prodi' => $data['homebase_prodi'],
                'jabatan_fungsional_saat_ini' => $data['jabatan_fungsional_saat_ini'],
            ]);

            return $dosen;
        });
    }

    public function deleteDosen(User $dosen): void
    {
        // onDelete('cascade') pada migrasi akan menghapus dosenDetail secara otomatis
        $dosen->delete();
    }
}