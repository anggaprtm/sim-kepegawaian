{{-- resources/views/tendik/surat_tugas/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Surat Tugas Baru') }}
        </h2>
    </x-slot> 
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('tendik.surat_tugas.store') }}" method="POST">
                        @csrf
                        
                        {{-- Tampilkan error validasi jika ada --}}
                        @if ($errors->any())
                            <div class="mb-4 p-4 bg-red-100 text-red-700 border border-red-400 rounded">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Perihal Surat --}}
                            <div>
                                <x-input-label for="perihal" value="Perihal Surat" />
                                <x-text-input id="perihal" class="block mt-1 w-full" type="text" name="perihal" :value="old('perihal')" required autofocus />
                            </div>

                            {{-- Nomor Surat --}}
                            <div>
                                <x-input-label for="nomor_surat" value="Nomor Surat" />
                                <x-text-input id="nomor_surat" class="block mt-1 w-full" type="text" name="nomor_surat" :value="old('nomor_surat')" required placeholder="Contoh: 123/UNIV/ST/2025" />
                            </div>
                            
                            {{-- Tanggal Surat --}}
                            <div>
                                <x-input-label for="tanggal_surat" value="Tanggal Surat" />
                                <x-text-input id="tanggal_surat" class="block mt-1 w-full" type="date" name="tanggal_surat" :value="old('tanggal_surat', date('Y-m-d'))" required />
                            </div>

                            {{-- Tujuan Surat (Dropdown Searchable) --}}
                            <div>
                                <x-input-label for="tujuan_user_id" value="Tujuan Surat (Pegawai yang ditugaskan)" />
                                <select name="tujuan_user_id" id="tujuan_user_id" class="mt-1 block w-full" required>
                                    <option></option> {{-- Option kosong untuk placeholder Select2 --}}
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" @selected(old('tujuan_user_id') == $user->id)>
                                            {{ $user->name }} (NIP: {{ $user->nip }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Keperluan / Kegiatan --}}
                            <div class="md:col-span-2">
                                <x-input-label for="keperluan" value="Keperluan Surat Tugas (Kegiatan)" />
                                <textarea id="keperluan" name="keperluan" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('keperluan') }}</textarea>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('tendik.surat_tugas.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                Batal
                            </a>
                            <x-primary-button>
                                Simpan & Buat Surat
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

{{-- Script untuk Select2 --}}
@push('scripts')
<script>
    // Pastikan jQuery sudah dimuat sebelum script ini
    $(document).ready(function() {
        $('#tujuan_user_id').select2({
            placeholder: "Ketik nama atau NIP untuk mencari...",
            width: '100%'
        });
    });
</script>
@endpush
