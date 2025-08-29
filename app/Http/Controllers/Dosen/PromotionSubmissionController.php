<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\PromotionSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\PromotionRequirement;
use App\Models\SubmissionDocument;

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
        
        // =================================================================
        // PERUBAHAN LOGIKA ADA DI SINI
        // =================================================================
        $possibleRanks = [];
        if (is_null($currentJabatan)) {
            // Jika belum punya jabatan, bisa mengajukan semua
            $possibleRanks = $allJabatan;
        } else {
            // Cari index jabatan saat ini
            $currentIndex = array_search($currentJabatan, $allJabatan);
            if ($currentIndex !== false && $currentIndex < count($allJabatan) - 1) {
                // Ambil semua jabatan setelah jabatan saat ini
                $possibleRanks = array_slice($allJabatan, $currentIndex + 1);
            }
        }

        // Cek apakah ada pengajuan yang masih aktif
        $finalStatuses = ['sk_terbit', 'gagal_sidang_pak', 'gagal_sidang_bpf', 'gagal_di_universitas'];
        $activeSubmission = PromotionSubmission::where('dosen_user_id', Auth::id())
            ->whereNotIn('status', $finalStatuses)
            ->exists();

        return view('dosen.promotion.create', compact('currentJabatan', 'possibleRanks', 'activeSubmission'));
    }

    public function store(Request $request)
    {
        $request->validate(['jabatan_tujuan' => 'required|string']);
        $user = Auth::user()->load('dosenDetail');

        $submission = PromotionSubmission::create([
            'dosen_user_id' => $user->id,
            'jabatan_fungsional_sebelumnya' => $user->dosenDetail->jabatan_fungsional_saat_ini,
            'jabatan_fungsional_tujuan' => $request->jabatan_tujuan,
            'status' => 'pengajuan_dibuat',
        ]);

        return redirect()->route('dosen.promotion.show', $submission->id)
            ->with('success', 'Pengajuan berhasil dibuat. Silakan unggah berkas persyaratan.');
    }

    public function show(PromotionSubmission $submission)
    {
        abort_if($submission->dosen_user_id !== Auth::id(), 403);
        
        $requirements = PromotionRequirement::where('jabatan_fungsional', $submission->jabatan_fungsional_tujuan)->get();
        
        // Kelompokkan dokumen yang ada berdasarkan ID persyaratannya untuk memudahkan akses di view
        $documentsByRequirement = $submission->documents->groupBy('promotion_requirement_id');
        
        $submission->load('logs.processor');

        return view('dosen.promotion.show', compact('submission', 'requirements', 'documentsByRequirement'));
    }

    public function uploadDocument(Request $request, PromotionSubmission $submission)
    {
        abort_if($submission->dosen_user_id !== Auth::id(), 403);
        
        $request->validate([
            'requirement_id' => 'required|exists:promotion_requirements,id',
            'document_files' => 'required|array',
            'document_files.*' => 'required|file|mimes:pdf|max:5120', // PDF max 5MB
        ]);

        $uploadedFiles = [];
        foreach ($request->file('document_files') as $file) {
            $path = $file->store("submissions/{$submission->id}", 'public');
            $document = $submission->documents()->create([
                'promotion_requirement_id' => $request->requirement_id,
                'path_file' => $path,
            ]);
            $uploadedFiles[] = [
                'id' => $document->id,
                'url' => asset('storage/' . $path),
                'name' => basename($path)
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Semua file berhasil diunggah.',
            'files' => $uploadedFiles
        ]);
    }

    public function deleteDocument(PromotionSubmission $submission, SubmissionDocument $document)
    {
        abort_if($submission->dosen_user_id !== Auth::id(), 403);
        abort_if($document->submission_id !== $submission->id, 403);

        Storage::disk('public')->delete($document->path_file);
        $document->delete();
        
        return response()->json(['success' => true, 'message' => 'Dokumen berhasil dihapus.']);
    }


    public function submitForVerification(PromotionSubmission $submission)
    {
        abort_if($submission->dosen_user_id !== Auth::id(), 403);
        if (!$submission->areDocumentsComplete()) {
            return back()->with('error', 'Semua dokumen persyaratan harus diunggah sebelum mengajukan verifikasi.');
        }
        $submission->update(['status' => 'diajukan_verifikasi']);
        return redirect()->route('dosen.promotion.index')->with('success', 'Pengajuan berhasil dikirim untuk diverifikasi.');
    }

    public function checkStatus(PromotionSubmission $submission)
    {
        abort_if($submission->dosen_user_id !== Auth::id(), 403);
        return response()->json([
            'is_complete' => $submission->areDocumentsComplete()
        ]);
    }
}
