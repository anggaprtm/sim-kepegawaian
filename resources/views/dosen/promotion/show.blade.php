<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pengajuan ke {{ $submission->jabatan_fungsional_tujuan }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"
             x-data="{
                // Inisialisasi daftar ID persyaratan yang sudah diunggah
                uploadedRequirementIds: {{ json_encode($documentsByRequirement->keys()) }},
                
                // Konversi data persyaratan dari PHP ke array JavaScript
                requirements: {{ json_encode($requirements) }},
                
                get mandatoryRequirementIds() {
                    return this.requirements.filter(req => req.is_wajib).map(req => req.id);
                },
                
                get isComplete() {
                    if (this.mandatoryRequirementIds.length === 0) return true;
                    return this.mandatoryRequirementIds.every(reqId => this.uploadedRequirementIds.includes(reqId));
                },

                handleDocumentChange(event) {
                    const { requirementId, status, remaining } = event.detail;
                    if (status === 'uploaded' && !this.uploadedRequirementIds.includes(requirementId)) {
                        this.uploadedRequirementIds.push(requirementId);
                    } else if (status === 'deleted' && remaining === 0) {
                        this.uploadedRequirementIds = this.uploadedRequirementIds.filter(id => id !== requirementId);
                    }
                }
             }"
             @document-changed.window="handleDocumentChange($event)">
            
            @include('dosen.promotion.partials.stepper')

            <!-- Card Checklist Persyaratan -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Ringkasan Checklist Persyaratan</h3>
                    <ol class="list-decimal list-inside grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2">
                        <template x-for="req in requirements" :key="req.id">
                            <li>
                                <div class="inline-flex items-center space-x-2">
                                    <i class="fa-solid" :class="{
                                        'fa-check-circle text-green-500': uploadedRequirementIds.includes(req.id),
                                        'fa-times-circle text-red-500': !uploadedRequirementIds.includes(req.id) && req.is_wajib,
                                        'fa-circle text-gray-400': !uploadedRequirementIds.includes(req.id) && !req.is_wajib
                                    }"></i>
                                    <span x-text="req.nama_dokumen"></span>
                                    <span x-show="!req.is_wajib" class="text-xs text-gray-500">(Opsional)</span>
                                </div>
                            </li>
                        </template>
                    </ol>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Unggah Dokumen Persyaratan</h3>
                    <div class="space-y-4">
                        @foreach($requirements as $req)
                            @php
                                // Ambil dokumen dari koleksi yang sudah dikelompokkan
                                $uploadedDocs = $documentsByRequirement->get($req->id, collect());
                            @endphp
                            <x-multi-file-uploader :requirement="$req" :submission="$submission" :uploadedDocuments="$uploadedDocs" />
                        @endforeach
                    </div>

                    <div class="mt-6 border-t pt-4">
                        <form action="{{ route('dosen.promotion.submit', $submission->id) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    x-bind:disabled="!isComplete || '{{ $submission->status }}' !== 'pengajuan_dibuat'"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:bg-gray-400 disabled:cursor-not-allowed">
                                Kumpulkan Berkas & Ajukan Verifikasi
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
