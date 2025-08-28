<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\PromotionSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PromotionSubmissionController extends Controller
{
    public function index()
    {
        $submissions = PromotionSubmission::where('dosen_user_id', Auth::id())->latest()->get();
        return view('dosen.promotion.index', compact('submissions'));
    }

    public function create()
    {
        $user = Auth::user()->load('dosenDetail');
        $currentJabatan = $user->dosenDetail->jabatan_fungsional_saat_ini;

        $allJabatan = config('promotion.jabatan_fungsional');
        $nextJabatan = null;

        if (is_null($currentJabatan)) {
            $nextJabatan = $allJabatan[0]; // Asisten Ahli
        } else {
            $currentIndex = array_search($currentJabatan, $allJabatan);
            if ($currentIndex !== false && isset($allJabatan[$currentIndex + 1])) {
                $nextJabatan = $allJabatan[$currentIndex + 1];
            }
        }

        // Cek apakah ada pengajuan yang masih aktif
        $activeSubmission = PromotionSubmission::where('dosen_user_id', Auth::id())
            ->whereNotIn('status', ['selesai', 'ditolak_permanen'])
            ->exists();

        return view('dosen.promotion.create', compact('currentJabatan', 'nextJabatan', 'activeSubmission'));
    }

    public function store(Request $request)
    {
        $request->validate(['jabatan_tujuan' => 'required|string']);
        $user = Auth::user()->load('dosenDetail');

        $submission = PromotionSubmission::create([
            'dosen_user_id' => $user->id,
            'jabatan_fungsional_sebelumnya' => $user->dosenDetail->jabatan_fungsional_saat_ini,
            'jabatan_fungsional_tujuan' => $request->jabatan_tujuan,
            'status' => 'pengajuan_dibuat', // Status awal
        ]);

        return redirect()->route('dosen.promotion.show', $submission->id)
            ->with('success', 'Pengajuan berhasil dibuat. Silakan unggah berkas persyaratan.');
    }

    public function show(PromotionSubmission $submission)
    {
        // Pastikan dosen hanya bisa melihat pengajuannya sendiri
        abort_if($submission->dosen_user_id !== Auth::id(), 403);

        $requirements = config('promotion.requirements.' . $submission->jabatan_fungsional_tujuan, []);
        $submission->load('documents', 'logs.processor');

        return view('dosen.promotion.show', compact('submission', 'requirements'));
    }

    public function uploadDocument(Request $request, PromotionSubmission $submission)
    {
        abort_if($submission->dosen_user_id !== Auth::id(), 403);

        $request->validate([
            'document_name' => 'required|string',
            'document_file' => 'required|file|mimes:pdf|max:5120', // PDF max 5MB
        ]);

        $file = $request->file('document_file');
        $path = $file->store("submissions/{$submission->id}", 'public');

        // Update atau buat baru record dokumen
        $submission->documents()->updateOrCreate(
            ['nama_dokumen' => $request->document_name],
            ['path_file' => $path]
        );

        return back()->with('success', 'Dokumen ' . $request->document_name . ' berhasil diunggah.');
    }

    public function submitForVerification(PromotionSubmission $submission)
    {
        abort_if($submission->dosen_user_id !== Auth::id(), 403);

        // Pastikan dokumen lengkap sebelum submit
        if (!$submission->areDocumentsComplete()) {
            return back()->with('error', 'Semua dokumen persyaratan harus diunggah sebelum mengajukan verifikasi.');
        }

        $submission->update(['status' => 'diajukan_verifikasi']);

        // Di sini kita bisa menambahkan log ke tabel submission_logs jika sudah dibuat

        return redirect()->route('dosen.promotion.index')->with('success', 'Pengajuan berhasil dikirim untuk diverifikasi.');
    }
}
