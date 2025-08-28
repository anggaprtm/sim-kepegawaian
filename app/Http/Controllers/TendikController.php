<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Services\TendikService;
use App\Http\Requests\StoreTendikRequest;
use App\Http\Requests\UpdateTendikRequest;

class TendikController extends Controller
{
    protected $tendikService;

    public function __construct(TendikService $tendikService)
    {
        $this->tendikService = $tendikService;
    }

    public function index()
    {
        $tendiks = $this->tendikService->getAllTendik();
        return view('tendik.index', compact('tendiks'));
    }

    public function create()
    {
        return view('tendik.create');
    }

    public function store(StoreTendikRequest $request)
    {
        $this->tendikService->storeTendik($request->validated());
        return redirect()->route('admin.tendik.index')->with('success', 'Data Tendik berhasil ditambahkan.');
    }

    public function edit(User $tendik)
    {
        $tendik->load('tendikDetail');
        return view('tendik.edit', compact('tendik'));
    }

    public function update(UpdateTendikRequest $request, User $tendik)
    {
        $this->tendikService->updateTendik($tendik, $request->validated());
        return redirect()->route('admin.tendik.index')->with('success', 'Data Tendik berhasil diperbarui.');
    }

    public function destroy(User $tendik)
    {
        $this->tendikService->deleteTendik($tendik);
        return redirect()->route('admin.tendik.index')->with('success', 'Data Tendik berhasil dihapus.');
    }
}