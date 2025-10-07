<?php

// app/Http/Controllers/Tendik/SuratTugasController.php
namespace App\Http\Controllers\Tendik;

use App\Http\Controllers\Controller;
use App\Models\SuratTugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratTugasController extends Controller
{
    public function index()
    {
        $suratTugas = SuratTugas::with('tujuan')->latest()->get();
        return view('tendik.surat_tugas.index', compact('suratTugas'));
    }

    public function create()
    {
        // Ambil semua user (dosen & tendik) untuk pilihan dropdown
        $users = User::role(['dosen', 'tendik'])->orderBy('name')->get();
        return view('tendik.surat_tugas.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'perihal' => 'required|string|max:255',
            'nomor_surat' => 'required|string|max:255|unique:surat_tugas',
            'tujuan_user_id' => 'required|exists:users,id',
            'keperluan' => 'required|string',
            'tanggal_surat' => 'required|date',
        ]);

        SuratTugas::create($request->all() + ['created_by_user_id' => Auth::id()]);

        return redirect()->route('tendik.surat_tugas.index')->with('success', 'Surat tugas berhasil dibuat.');
    }
    
    public function download(SuratTugas $suratTugas)
    {
        $pdf = Pdf::loadView('pdf.surat_tugas_custom', compact('suratTugas'));
        $fileName = 'ST-' . str_replace('/', '-', $suratTugas->nomor_surat) . '.pdf';

        return $pdf->download($fileName);
    }
}