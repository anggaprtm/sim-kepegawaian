<?php

namespace App\Http\Controllers;

use App\Models\PromotionSubmission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('superadmin')) {
            $stats = [
                'total_dosen' => User::role('dosen')->count(),
                'total_tendik' => User::role('tendik')->count(),
                'total_pengajuan' => PromotionSubmission::count(),
            ];
            return view('dashboard.superadmin', compact('stats'));

        } elseif ($user->hasRole('dosen')) {
            // PERBAIKAN: Mengambil pengajuan yang terakhir di-update
            $mySubmission = PromotionSubmission::where('dosen_user_id', $user->id)
                ->latest('updated_at')
                ->first();
            return view('dashboard.dosen', compact('mySubmission'));

        } elseif ($user->hasRole('tendik')) {
            $stats = [
                'perlu_verifikasi' => PromotionSubmission::where('status', 'diajukan_verifikasi')->count(),
                'perlu_asesor' => PromotionSubmission::where('status', 'berkas_disetujui')->count(),
                'perlu_sidang_pak' => PromotionSubmission::where('status', 'penilaian_asesor')->count(),
                'perlu_sidang_bpf' => PromotionSubmission::where('status', 'lulus_sidang_pak')->count(),
            ];
            return view('dashboard.tendik', compact('stats'));
        }

        // Fallback
        return view('dashboard');
    }
}
