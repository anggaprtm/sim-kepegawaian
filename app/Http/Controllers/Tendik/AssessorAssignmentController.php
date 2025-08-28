<?php

namespace App\Http\Controllers\Tendik;

use App\Http\Controllers\Controller;
use App\Models\PromotionSubmission;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class AssessorAssignmentController extends Controller
{
    public function index()
    {
        $submissions = PromotionSubmission::with('dosen')
            ->where('status', 'berkas_disetujui')
            ->latest()
            ->get();
        return view('tendik.assessor.index', compact('submissions'));
    }

    public function show(PromotionSubmission $submission)
    {
        // Pastikan statusnya benar
        abort_if($submission->status !== 'berkas_disetujui', 404);

        $assessors = User::role('asesor')->where('id', '!=', $submission->dosen_user_id)->get();
        return view('tendik.assessor.show', compact('submission', 'assessors'));
    }

    public function store(Request $request, PromotionSubmission $submission)
    {
        $request->validate([
            'assessor_ids' => 'required|array|min:1|max:2',
            'assessor_ids.*' => 'exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Attach asesor ke submission
        foreach ($request->assessor_ids as $assessorId) {
            $submission->assessors()->attach($assessorId, [
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);
        }

        // Update status submission
        $submission->update(['status' => 'penilaian_asesor']);

        return redirect()->route('tendik.assessor.letter', $submission->id)
            ->with('success', 'Asesor berhasil ditugaskan. Silakan unduh Surat Tugas.');
    }

    public function generateAssignmentLetter(PromotionSubmission $submission)
    {
        $submission->load('dosen.dosenDetail', 'assessors');

        $pdf = Pdf::loadView('pdf.surat_tugas', compact('submission'));
        
        // Nama file: ST_NAMA_DOSEN_TANGGAL.pdf
        $fileName = 'ST_' . Str::slug($submission->dosen->name) . '_' . now()->format('Ymd') . '.pdf';

        return $pdf->download($fileName);
    }
}