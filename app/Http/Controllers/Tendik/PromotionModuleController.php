<?php

namespace App\Http\Controllers\Tendik;

use App\Http\Controllers\Controller;
use App\Models\PromotionSubmission;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PromotionRequirement; // <-- Import model

class PromotionModuleController extends Controller
{
    public function index()
    {
        $submissions = PromotionSubmission::with('dosen.dosenDetail')
            ->latest()
            ->get();
            
        return view('tendik.promotion_module.index', compact('submissions'));
    }

    public function show(PromotionSubmission $submission)
    {
        // Ambil persyaratan dari database
        $requirements = PromotionRequirement::where('jabatan_fungsional', $submission->jabatan_fungsional_tujuan)->get();
        
        // Kelompokkan dokumen yang ada berdasarkan ID persyaratannya
        $documentsByRequirement = $submission->documents->groupBy('promotion_requirement_id');
        
        // Muat data lain yang diperlukan
        $submission->load('dosen.dosenDetail', 'assessors');
        $assessors = User::role('asesor')->where('id', '!=', $submission->dosen_user_id)->get();
        
        return view('tendik.promotion_module.show', compact('submission', 'assessors', 'requirements', 'documentsByRequirement'));
    }
}