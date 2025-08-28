<?php
namespace App\Http\Controllers\Tendik;

use App\Http\Controllers\Controller;
use App\Models\PakSession;
use App\Models\PromotionSubmission;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PakSessionController extends Controller
{
    public function index() {
        $sessions = PakSession::withCount('submissions')->latest()->get();
        return view('tendik.pak_session.index', compact('sessions'));
    }

    public function create() {
        // Ambil semua ID pengajuan yang sudah dijadwalkan
        $scheduledSubmissionIds = DB::table('pak_session_submissions')->pluck('submission_id');

        // Ambil pengajuan yang siap DAN TIDAK ADA di dalam daftar yang sudah dijadwalkan
        $availableSubmissions = PromotionSubmission::with('dosen')
            ->where('status', 'penilaian_asesor')
            ->whereNotIn('id', $scheduledSubmissionIds)
            ->get();
            
        return view('tendik.pak_session.create', compact('availableSubmissions'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama_sesi' => 'required|string|max:255',
            'tanggal_sidang' => 'required|date',
            'submission_ids' => 'required|array|min:1',
            'submission_ids.*' => 'exists:promotion_submissions,id',
        ]);

        $session = PakSession::create($request->only(['nama_sesi', 'tanggal_sidang']));
        $session->submissions()->attach($request->submission_ids);

        // Update status semua submission yang dijadwalkan
        PromotionSubmission::whereIn('id', $request->submission_ids)->update(['status' => 'sidang_pak_dijadwalkan']);

        return redirect()->route('tendik.pak_session.show', $session)->with('success', 'Sidang PAK berhasil dijadwalkan.');
    }

    public function show(PakSession $sidang_pak) // <-- UBAH DI SINI
    {
        $sidang_pak->load('submissions.dosen'); // <-- UBAH DI SINI
        return view('tendik.pak_session.show', ['session' => $sidang_pak]); // <-- UBAH DI SINI
    }

    public function processResults(Request $request, PakSession $sidang_pak) // <-- UBAH DI SINI
    {
        $request->validate([
            'results' => 'required|array',
            'results.*' => 'in:lulus,tidak_lulus',
            'notula' => 'required|string',
        ]);

        foreach ($request->results as $submissionId => $result) {
            $newStatus = ($result == 'lulus') ? 'lulus_sidang_pak' : 'gagal_sidang_pak';
            PromotionSubmission::find($submissionId)->update(['status' => $newStatus]);
        }

        $sidang_pak->update([ // <-- UBAH DI SINI
            'notula' => $request->notula,
            'status' => 'selesai'
        ]);

        return redirect()->route('tendik.pak_session.index')->with('success', 'Hasil Sidang PAK berhasil disimpan.');
    }

    public function generateInvitation(PakSession $pak_session)
    {
        // ambil submissions beserta dosen
        $submissionsWithDosen = $pak_session->submissions()->with('dosen')->get();

        // debug kalau perlu
        // dd($pak_session->id, $submissionsWithDosen->count());

        $pdf = Pdf::loadView('pdf.undangan_pak', [
            'session' => $pak_session,          // dipakai di blade sebagai $session
            'submissions' => $submissionsWithDosen,
        ]);

        return $pdf->download(
            'undangan-sidang-pak-' . Str::slug($pak_session->nama_sesi) . '.pdf'
        );
    }

}