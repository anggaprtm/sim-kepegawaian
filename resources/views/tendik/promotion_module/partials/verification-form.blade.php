<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Kolom Kiri: Checklist Dokumen -->
    <div class="md:col-span-2">
        <h4 class="font-semibold mb-2">Checklist Dokumen Persyaratan</h4>
        <ul class="space-y-3 border rounded-md p-4">
            @foreach($requirements as $req)
                @php
                    // Cek apakah ada dokumen yang terunggah untuk persyaratan ini
                    $uploadedDocs = $submission->documents->where('promotion_requirement_id', $req->id);
                @endphp
                <li class="flex justify-between items-center py-2 border-b last:border-b-0">
                    <div>
                        <p>{{ $req->nama_dokumen }} <span class="text-sm {{ $req->is_wajib ? 'text-red-500' : 'text-green-500' }}">({{ $req->is_wajib ? 'Wajib' : 'Opsional' }})</span></p>
                        @if($uploadedDocs->isNotEmpty())
                            @foreach($uploadedDocs as $doc)
                                <a href="{{ asset('storage/' . $doc->path_file) }}" target="_blank" class="text-xs text-blue-500 underline block ml-4">
                                    <i class="fa-solid fa-file-pdf"></i> {{ basename($doc->path_file) }}
                                </a>
                            @endforeach
                        @else
                            <p class="text-xs text-gray-500 ml-4">Belum diunggah</p>
                        @endif
                    </div>
                    @if($uploadedDocs->isNotEmpty())
                        <i class="fa-solid fa-check-circle text-green-500 text-lg"></i>
                    @else
                        <i class="fa-solid fa-times-circle text-red-500 text-lg"></i>
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