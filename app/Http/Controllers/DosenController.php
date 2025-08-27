<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\DosenService;
use App\Http\Requests\StoreDosenRequest;
use App\Http\Requests\UpdateDosenRequest;

class DosenController extends Controller
{
    protected $dosenService;

    public function __construct(DosenService $dosenService)
    {
        $this->dosenService = $dosenService;
    }

    public function index()
    {
        $dosens = $this->dosenService->getAllDosen();
        return view('dosen.index', compact('dosens'));
    }

    public function create()
    {
        return view('dosen.create');
    }

    public function store(StoreDosenRequest $request)
    {
        $this->dosenService->storeDosen($request->validated());
        return redirect()->route('dosen.index')->with('success', 'Data Dosen berhasil ditambahkan.');
    }

    public function show(User $dosen)
    {
        // Tampilkan detail jika diperlukan, atau redirect ke edit
        return view('dosen.edit', compact('dosen'));
    }

    public function edit(User $dosen)
    {
        // Pastikan relasi sudah di-load
        $dosen->load('dosenDetail');
        return view('dosen.edit', compact('dosen'));
    }

    public function update(UpdateDosenRequest $request, User $dosen)
    {
        $this->dosenService->updateDosen($dosen, $request->validated());
        return redirect()->route('dosen.index')->with('success', 'Data Dosen berhasil diperbarui.');
    }

    public function destroy(User $dosen)
    {
        $this->dosenService->deleteDosen($dosen);
        return redirect()->route('dosen.index')->with('success', 'Data Dosen berhasil dihapus.');
    }
}
