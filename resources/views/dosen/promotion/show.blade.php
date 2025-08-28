<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pengajuan ke {{ $submission->jabatan_fungsional_tujuan }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Checklist Persyaratan Dokumen</h3>

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
                    @endif
                    
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <ul class="space-y-4">
                        @foreach($requirements as $req)
                        @php
                            $uploadedDoc = $submission->documents->firstWhere('nama_dokumen', $req);
                        @endphp
                        <li class="p-4 border rounded-md flex justify-between items-center">
                            <div>
                                <span class="font-semibold">{{ $req }}</span>
                                @if($uploadedDoc)
                                <div class="text-sm text-green-600">
                                    <a href="{{ asset('storage/' . $uploadedDoc->path_file) }}" target="_blank" class="underline">Sudah diunggah. Lihat file.</a>
                                </div>
                                @else
                                <div class="text-sm text-red-600">Belum diunggah</div>
                                @endif
                            </div>
                            <form action="{{ route('dosen.promotion.upload', $submission->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="document_name" value="{{ $req }}">
                                <input type="file" name="document_file" required class="text-sm">
                                <x-primary-button class="ml-2">Upload</x-primary-button>
                            </form>
                        </li>
                        @endforeach
                    </ul>

                    <div class="mt-6 border-t pt-4">
                        @if($submission->areDocumentsComplete() && $submission->status == 'pengajuan_dibuat')
                            <form action="{{ route('dosen.promotion.submit', $submission->id) }}" method="POST">
                                @csrf
                                <x-primary-button>
                                    Ajukan Verifikasi
                                </x-primary-button>
                            </form>
                        @else
                            <x-primary-button disabled>Ajukan Verifikasi</x-primary-button>
                            <p class="text-sm text-gray-500 mt-2">
                                @if($submission->status != 'pengajuan_dibuat')
                                    Pengajuan sudah dalam proses verifikasi atau tahap selanjutnya.
                                @else
                                    Tombol "Ajukan Verifikasi" akan aktif jika semua dokumen persyaratan sudah lengkap diunggah.
                                @endif
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
