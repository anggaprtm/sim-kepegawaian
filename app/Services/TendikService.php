<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TendikService
{
    public function getAllTendik()
    {
        return User::where('role', 'tendik')->with('tendikDetail')->latest()->get();
    }

    public function storeTendik(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'nip' => $data['nip'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'tendik',
            ]);

            $user->tendikDetail()->create([
                'jenis_kelamin' => $data['jenis_kelamin'],
                'tempat_lahir' => $data['tempat_lahir'],
                'tanggal_lahir' => $data['tanggal_lahir'],
                'jabatan' => $data['jabatan'],
                'status_kepegawaian' => $data['status_kepegawaian'],
                'alamat' => $data['alamat'],
                'no_hp' => $data['no_hp'],
            ]);

            $user->assignRole('tendik');
            return $user;
        });
    }

    public function updateTendik(User $tendik, array $data): User
    {
        return DB::transaction(function () use ($tendik, $data) {
            $tendik->update([
                'name' => $data['name'],
                'nip' => $data['nip'],
                'email' => $data['email'],
            ]);

            if (!empty($data['password'])) {
                $tendik->update(['password' => Hash::make($data['password'])]);
            }

            $tendik->tendikDetail()->update([
                'jenis_kelamin' => $data['jenis_kelamin'],
                'tempat_lahir' => $data['tempat_lahir'],
                'tanggal_lahir' => $data['tanggal_lahir'],
                'jabatan' => $data['jabatan'],
                'status_kepegawaian' => $data['status_kepegawaian'],
                'alamat' => $data['alamat'],
                'no_hp' => $data['no_hp'],
            ]);

            return $tendik;
        });
    }

    public function deleteTendik(User $tendik): void
    {
        $tendik->delete();
    }
}