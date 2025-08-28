<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Pengajuan Kenaikan Pangkat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Dosen</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jabatan Tujuan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Pengajuan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status Terakhir</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($submissions as $submission)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $submission->dosen->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $submission->jabatan_fungsional_tujuan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $submission->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if(Str::contains($submission->status, 'gagal') || Str::contains($submission->status, 'revisi')) bg-red-100 text-red-800
                                            @elseif(Str::contains($submission->status, 'sk_terbit')) bg-green-100 text-green-800
                                            @else bg-blue-100 text-blue-800 @endif">
                                            {{ Str::title(str_replace('_', ' ', $submission->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('tendik.promotion.show', $submission->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                            Detail & Proses
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada pengajuan.</td>
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