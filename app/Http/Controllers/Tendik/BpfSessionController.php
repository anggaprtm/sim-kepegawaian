<?php
namespace App\Http\Controllers\Tendik;

use App\Http\Controllers\Controller;
use App\Models\BpfSession;
use App\Models\PromotionSubmission;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BpfSessionController extends Controller
{
    public function index() {
        $sessions = BpfSession::withCount('submissions')->latest()->get();
        return view('tendik.bpf_session.index', compact('sessions'));
    }

    public function create() {
        // Ambil semua ID pengajuan yang sudah dijadwalkan
        $scheduledSubmissionIds = DB::table('bpf_session_submissions')->pluck('submission_id');

        // Ambil pengajuan yang siap DAN TIDAK ADA di dalam daftar yang sudah dijadwalkan
        $availableSubmissions = PromotionSubmission::with('dosen')
            ->where('status', 'lulus_sidang_pak')
            ->whereNotIn('id', $scheduledSubmissionIds)
            ->get();

        return view('tendik.bpf_session.create', compact('availableSubmissions'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama_sesi' => 'required|string|max:255',
            'tanggal_sidang' => 'required|date',
            'submission_ids' => 'required|array|min:1',
            'submission_ids.*' => 'exists:promotion_submissions,id',
        ]);

        $session = BpfSession::create($request->only(['nama_sesi', 'tanggal_sidang']));
        $session->submissions()->attach($request->submission_ids);

        PromotionSubmission::whereIn('id', $request->submission_ids)->update(['status' => 'sidang_bpf_dijadwalkan']); // <-- Perubahan di sini

        return redirect()->route('tendik.bpf_session.show', $session)->with('success', 'Sidang BPF berhasil dijadwalkan.');
    }

    public function show(BpfSession $bpf_session) {
        $bpf_session->load('submissions.dosen');
        return view('tendik.bpf_session.show', ['session' => $bpf_session]);
    }

    public function processResults(Request $request, BpfSession $bpf_session) {
        $request->validate([
            'results' => 'required|array',
            'results.*' => 'in:lulus,tidak_lulus',
            'notula' => 'required|string',
        ]);

        foreach ($request->results as $submissionId => $result) {
            $newStatus = ($result == 'lulus') ? 'lulus_sidang_bpf' : 'gagal_sidang_bpf'; // <-- Perubahan di sini
            PromotionSubmission::find($submissionId)->update(['status' => $newStatus]);
        }

        $bpf_session->update([
            'notula' => $request->notula,
            'status' => 'selesai'
        ]);

        return redirect()->route('tendik.bpf_session.index')->with('success', 'Hasil Sidang BPF berhasil disimpan.');
    }
    
    public function generateInvitation(BpfSession $sidang_bpf)
    {
        // pastikan relasi submissions & dosen di-load
        $sidang_bpf->load('submissions.dosen');

        $pdf = Pdf::loadView('pdf.undangan_bpf', [
            'session' => $sidang_bpf
        ]);

        return $pdf->download('undangan-sidang-bpf-'.Str::slug($sidang_bpf->nama_sesi).'.pdf');
    }
}
