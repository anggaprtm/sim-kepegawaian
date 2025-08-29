<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Persyaratan Kenaikan Pangkat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Form Tambah Persyaratan -->
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-medium mb-4">Tambah Persyaratan Baru</h3>
                <form action="{{ route('admin.requirements.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    @csrf
                    <div>
                        <x-input-label for="jabatan_fungsional" value="Jabatan Fungsional" />
                        <select name="jabatan_fungsional" id="jabatan_fungsional" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            @foreach($jabatanList as $jabatan)
                            <option value="{{ $jabatan }}">{{ $jabatan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-input-label for="nama_dokumen" value="Nama Dokumen Persyaratan" />
                        <x-text-input id="nama_dokumen" name="nama_dokumen" class="mt-1 block w-full" required />
                    </div>
                    <div>
                        <x-input-label for="is_wajib" value="Sifat" />
                        <select name="is_wajib" id="is_wajib" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="1">Wajib</option>
                            <option value="0">Opsional</option>
                        </select>
                    </div>
                    <div class="flex items-center space-x-4">
                        {{-- Tambahkan Checkbox ini --}}
                        <label for="allow_multiple_files" class="flex items-center">
                            <input type="hidden" name="allow_multiple_files" value="0">
                            <input id="allow_multiple_files" name="allow_multiple_files" type="checkbox" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm">
                            <span class="ms-2 text-sm text-gray-600">Boleh Multi-File</span>
                        </label>
                        <x-primary-button>Tambah</x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Daftar Persyaratan yang Ada -->
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-medium mb-4">Daftar Persyaratan Saat Ini</h3>
                <div class="space-y-4">
                    @foreach($requirements as $jabatan => $docs)
                    <div>
                        <h4 class="font-semibold">{{ $jabatan }}</h4>
                        <ul class="list-disc list-inside mt-2 space-y-2">
                            @foreach($docs as $doc)
                            <li class="ml-4 p-2 border-b flex justify-between items-center">
                                <span>{{ $doc->nama_dokumen }} - <span class="text-sm {{ $doc->is_wajib ? 'text-red-600' : 'text-green-600' }}">{{ $doc->is_wajib ? 'Wajib' : 'Opsional' }}</span></span>
                                <form action="{{ route('admin.requirements.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline text-sm">Hapus</button>
                                </form>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>