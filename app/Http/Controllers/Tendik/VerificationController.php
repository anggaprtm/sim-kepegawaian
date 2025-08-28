<?php

namespace App\Http\Controllers\Tendik;

use App\Http\Controllers\Controller;
use App\Models\PromotionSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    public function index()
    {
        // Ambil pengajuan yang perlu diverifikasi atau sedang direvisi
        $submissions = PromotionSubmission::with('dosen.dosenDetail')
            ->whereIn('status', ['diajukan_verifikasi', 'revisi_berkas'])
            ->latest()
            ->get();
            
        return view('tendik.verification.index', compact('submissions'));
    }

    public function show(PromotionSubmission $submission)
    {
        $submission->load('dosen.dosenDetail', 'documents');
        $requirements = config('promotion.requirements.' . $submission->jabatan_fungsional_tujuan, []);
        
        return view('tendik.verification.show', compact('submission', 'requirements'));
    }

    public function process(Request $request, PromotionSubmission $submission)
    {
        $request->validate([
            'action' => 'required|in:approve,revise',
            'catatan_revisi' => 'nullable|string|required_if:action,revise',
        ]);

        if ($request->action == 'approve') {
            $submission->update([
                'status' => 'berkas_disetujui',
                'catatan_revisi' => null, // Hapus catatan revisi jika ada
            ]);
            // Tambah log di sini
            return redirect()->route('tendik.verification.index')->with('success', 'Pengajuan berhasil disetujui.');
        }

        if ($request->action == 'revise') {
            $submission->update([
                'status' => 'revisi_berkas',
                'catatan_revisi' => $request->catatan_revisi,
            ]);
            // Tambah log di sini
            return redirect()->route('tendik.verification.index')->with('success', 'Pengajuan dikembalikan untuk revisi.');
        }

        return back()->with('error', 'Aksi tidak valid.');
    }
}
