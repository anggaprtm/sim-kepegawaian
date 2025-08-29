<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromotionRequirement;
use Illuminate\Http\Request;

class RequirementController extends Controller
{
    public function index() {
        $requirements = PromotionRequirement::orderBy('jabatan_fungsional')->get()->groupBy('jabatan_fungsional');
        $jabatanList = config('promotion.jabatan_fungsional');
        return view('admin.requirements.index', compact('requirements', 'jabatanList'));
    }

    public function store(Request $request) {
        $request->validate([
            'jabatan_fungsional' => 'required|string',
            'nama_dokumen' => 'required|string',
            'is_wajib' => 'required|boolean',
            'allow_multiple_files' => 'required|boolean', // <-- Tambahkan ini
        ]);
        PromotionRequirement::create($request->all());
        return back()->with('success', 'Persyaratan berhasil ditambahkan.');
    }

    public function update(Request $request, PromotionRequirement $requirement) {
        $request->validate(['nama_dokumen' => 'required|string', 'is_wajib' => 'required|boolean']);
        $requirement->update($request->all());
        return back()->with('success', 'Persyaratan berhasil diperbarui.');
    }

    public function destroy(PromotionRequirement $requirement) {
        $requirement->delete();
        return back()->with('success', 'Persyaratan berhasil dihapus.');
    }
}
