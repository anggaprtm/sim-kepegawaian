<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Data Tendik</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('tendik.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 mb-4">
                        + Tambah Tendik
                    </a>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium">NIP</th>
                                <th class="px-6 py-3 text-left text-xs font-medium">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium">Jabatan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($tendiks as $tendik)
                            <tr>
                                <td class="px-6 py-4">{{ $tendik->nip }}</td>
                                <td class="px-6 py-4">{{ $tendik->name }}</td>
                                <td class="px-6 py-4">{{ $tendik->tendikDetail->jabatan ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('tendik.edit', $tendik->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                    <form action="{{ route('tendik.destroy', $tendik->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="px-6 py-4 text-center">Data tidak ditemukan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
