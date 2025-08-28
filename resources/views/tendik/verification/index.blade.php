<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Pengajuan Kenaikan Jabatan') }}
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
                                    <th class="px-6 py-3 text-left text-xs font-medium">Nama Dosen</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium">Jabatan Tujuan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium">Tanggal Pengajuan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($submissions as $submission)
                                <tr>
                                    <td class="px-6 py-4">{{ $submission->dosen->name }}</td>
                                    <td class="px-6 py-4">{{ $submission->jabatan_fungsional_tujuan }}</td>
                                    <td class="px-6 py-4">{{ $submission->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $submission->status == 'revisi_berkas' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ str_replace('_', ' ', Str::title($submission->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('tendik.verification.show', $submission->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                            Proses
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center">Tidak ada pengajuan untuk diproses.</td>
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
