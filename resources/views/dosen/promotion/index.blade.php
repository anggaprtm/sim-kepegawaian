<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Pengajuan Kenaikan Jabatan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Riwayat Pengajuan Anda</h3>
                        <a href="{{ route('dosen.promotion.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            + Buat Pengajuan Baru
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 border border-green-400 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Pengajuan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jabatan Tujuan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status & Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($submissions as $submission)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $submission->created_at->format('d M Y H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $submission->jabatan_fungsional_tujuan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if(Str::contains($submission->status, 'gagal') || Str::contains($submission->status, 'revisi')) bg-red-100 text-red-800
                                                @elseif(Str::contains($submission->status, 'sk_terbit')) bg-green-100 text-green-800
                                                @else bg-blue-100 text-blue-800 @endif">
                                                {{ Str::title(str_replace('_', ' ', $submission->status)) }}
                                            </span>

                                            @if ($submission->status == 'sk_terbit' && $submission->sk_file_path)
                                                <a href="{{ asset('storage/' . $submission->sk_file_path) }}" target="_blank" class="text-sm text-green-600 hover:text-green-900 underline">
                                                    Unduh SK
                                                </a>
                                            @elseif ($submission->status == 'pengajuan_dibuat' || $submission->status == 'revisi_berkas')
                                                <a href="{{ route('dosen.promotion.show', $submission->id) }}" class="text-sm text-indigo-600 hover:text-indigo-900 underline">
                                                    Lengkapi Berkas
                                                </a>
                                            @endif
                                        </div>
                                        @if($submission->status == 'revisi_berkas' && $submission->catatan_revisi)
                                            <p class="text-xs text-gray-500 mt-1"><strong>Catatan:</strong> {{ $submission->catatan_revisi }}</p>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                        Anda belum memiliki riwayat pengajuan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
