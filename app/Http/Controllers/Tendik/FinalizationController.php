<?php
namespace App\Http\Controllers\Tendik;

use App\Http\Controllers\Controller;
use App\Models\PromotionSubmission;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class FinalizationController extends Controller
{
    public function index() {
        // Dosen yang siap diajukan ke universitas
        $forUniversity = PromotionSubmission::with('dosen')
            ->where('status', 'lulus_sidang_bpf')
            ->get();

        // Dosen yang sedang menunggu hasil dari universitas
        $pendingResult = PromotionSubmission::with('dosen')
            ->where('status', 'diajukan_ke_universitas')
            ->get();

        return view('tendik.finalization.index', compact('forUniversity', 'pendingResult'));
    }

    public function generateUniversityCoverLetter(Request $request) {
        $request->validate([
            'submission_ids' => 'required|array|min:1',
            'submission_ids.*' => 'exists:promotion_submissions,id',
        ]);

        $submissions = PromotionSubmission::with('dosen.dosenDetail')
            ->whereIn('id', $request->submission_ids)
            ->get();

        // Update status menjadi "diajukan ke universitas"
        PromotionSubmission::whereIn('id', $request->submission_ids)->update(['status' => 'diajukan_ke_universitas']);

        $pdf = Pdf::loadView('pdf.surat_pengantar_univ', compact('submissions'));
        return $pdf->download('surat-pengantar-universitas-'.now()->format('Ymd').'.pdf');
    }

    public function processFinalResult(Request $request, PromotionSubmission $submission) {
        $request->validate([
            'result' => 'required|in:lulus,gagal',
            'sk_file' => 'nullable|file|mimes:pdf|max:5120|required_if:result,lulus',
            'catatan_penolakan' => 'nullable|string|required_if:result,gagal',
        ]);

        if ($request->result == 'lulus') {
            $path = $request->file('sk_file')->store("sk_files/{$submission->id}", 'public');
            $submission->update([
                'status' => 'sk_terbit',
                'sk_file_path' => $path,
            ]);
        } else {
            $submission->update([
                'status' => 'gagal_di_universitas',
                'catatan_penolakan' => $request->catatan_penolakan,
            ]);
        }

        return back()->with('success', 'Hasil akhir berhasil disimpan.');
    }
}
