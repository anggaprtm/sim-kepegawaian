<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Kolom Kiri: Checklist Dokumen -->
    <div class="md:col-span-2">
        <h4 class="font-semibold mb-2">Checklist Dokumen Persyaratan</h4>
        <ul class="space-y-3 border rounded-md p-4">
            @foreach($requirements as $req)
            @php $doc = $submission->documents->firstWhere('nama_dokumen', $req); @endphp
            <li class="flex justify-between items-center">
                <span>{{ $req }}</span>
                @if($doc)
                <a href="{{ asset('storage/' . $doc->path_file) }}" target="_blank" class="text-sm text-blue-500 underline">Lihat File</a>
                @else
                <span class="text-sm text-red-500">Belum Diunggah</span>
                @endif
            </li>
            @endforeach
        </ul>
    </div>

    <!-- Kolom Kanan: Aksi -->
    <div>
        <h4 class="font-semibold mb-2">Tindakan Verifikasi</h4>
        <form action="{{ route('tendik.verification.process', $submission->id) }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="flex items-center">
                        <input type="radio" name="action" value="approve" class="form-radio" checked>
                        <span class="ml-2">Setujui Berkas</span>
                    </label>
                    <label class="flex items-center mt-2">
                        <input type="radio" name="action" value="revise" class="form-radio">
                        <span class="ml-2">Kembalikan untuk Revisi</span>
                    </label>
                </div>
                <div>
                    <x-input-label for="catatan_revisi" value="Catatan Revisi (Wajib diisi jika dikembalikan)" />
                    <textarea name="catatan_revisi" id="catatan_revisi" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                    @error('catatan_revisi')<span class="text-sm text-red-500">{{ $message }}</span>@enderror
                </div>
                <div>
                    <x-primary-button>Simpan Keputusan</x-primary-button>
                </div>
            </div>
        </form>
    </div>
</div>
