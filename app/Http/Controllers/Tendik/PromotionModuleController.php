<?php

namespace App\Http\Controllers\Tendik;

use App\Http\Controllers\Controller;
use App\Models\PromotionSubmission;
use App\Models\User;
use Illuminate\Http\Request;

class PromotionModuleController extends Controller
{
    /**
     * Menampilkan halaman utama dengan daftar semua pengajuan.
     */
    public function index()
    {
        $submissions = PromotionSubmission::with('dosen.dosenDetail')
            ->latest()
            ->get();
            
        return view('tendik.promotion_module.index', compact('submissions'));
    }

    /**
     * Menampilkan halaman detail untuk satu pengajuan.
     * Halaman ini akan secara dinamis menampilkan form proses yang sesuai dengan status pengajuan saat ini.
     */
    public function show(PromotionSubmission $submission)
    {
         $submission->load('dosen.dosenDetail', 'documents', 'assessors', 'logs.processor');
        
        // Data untuk form pemilihan asesor
        $assessors = User::role('asesor')->where('id', '!=', $submission->dosen_user_id)->get();
        
        // Data persyaratan dokumen
        $requirements = config('promotion.requirements.' . $submission->jabatan_fungsional_tujuan, []);

        return view('tendik.promotion_module.show', compact('submission', 'assessors', 'requirements'));
    }
}
