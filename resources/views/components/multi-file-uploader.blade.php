@props(['requirement', 'submission', 'uploadedDocuments' => [], 'isLocked' => false])

<div x-data="{
    stagedFiles: [],
    uploadedFiles: {{ json_encode($uploadedDocuments->map(fn($doc) => ['id' => $doc->id, 'url' => asset('storage/' . $doc->path_file), 'name' => basename($doc->path_file)])) }},
    isDragging: false,
    uploading: false,
    progress: 0,
    allowMultiple: @json($requirement->allow_multiple_files),
    handleFiles(files) {
        let fileArray = Array.from(files).filter(file => file.type === 'application/pdf');
        if (this.allowMultiple) {
            this.stagedFiles = [...this.stagedFiles, ...fileArray];
        } else {
            if (fileArray.length > 0) {
                this.stagedFiles = [fileArray[0]];
            }
        }
    },
    removeStagedFile(index) {
        this.stagedFiles.splice(index, 1);
    },
    uploadAll() {
        if (this.stagedFiles.length === 0) return;
        this.uploading = true;
        this.progress = 0;

        let formData = new FormData();
        formData.append('requirement_id', '{{ $requirement->id }}');
        this.stagedFiles.forEach(file => formData.append('document_files[]', file));
        formData.append('_token', '{{ csrf_token() }}');

        axios.post('{{ route('dosen.promotion.upload', $submission->id) }}', formData, {
            onUploadProgress: (e) => { this.progress = Math.round((e.loaded * 100) / e.total); }
        }).then(response => {
            this.uploadedFiles = [...this.uploadedFiles, ...response.data.files];
            this.stagedFiles = [];
            window.dispatchEvent(new CustomEvent('document-changed', { detail: { requirementId: {{ $requirement->id }}, status: 'uploaded' }}));
        }).catch(error => console.error(error))
          .finally(() => { this.uploading = false; this.progress = 0; });
    },
    deleteFile(fileId, index) {
        if (!confirm('Yakin ingin menghapus file ini?')) return;
        axios.delete(`/dosen/pengajuan/{{ $submission->id }}/document/${fileId}`, { data: { _token: '{{ csrf_token() }}' } })
            .then(response => {
                this.uploadedFiles.splice(index, 1);
                window.dispatchEvent(new CustomEvent('document-changed', { detail: { requirementId: {{ $requirement->id }}, status: 'deleted', remaining: this.uploadedFiles.length }}));
            }).catch(error => console.error(error));
    }
}" class="border rounded-lg p-4">
    <h4 class="font-semibold">{{ $requirement->nama_dokumen }} 
        <span class="text-sm font-normal {{ $requirement->is_wajib ? 'text-red-500' : 'text-green-600' }}">({{ $requirement->is_wajib ? 'Wajib' : 'Opsional' }})</span>
        @if($requirement->allow_multiple_files)
            <span class="text-xs font-normal text-blue-500">(Boleh lebih dari satu)</span>
        @endif
    </h4>
    
    <!-- Daftar File yang Sudah Terunggah -->
    <div x-show="uploadedFiles.length > 0" class="mt-2 space-y-2">
        <template x-for="(file, index) in uploadedFiles" :key="file.id">
            <div class="flex items-center justify-between bg-gray-50 p-2 rounded-md">
                <a :href="file.url" target="_blank" class="text-sm text-blue-600 hover:underline truncate">
                    <i class="fa-solid fa-file-pdf mr-2"></i><span x-text="file.name"></span>
                </a>
                {{-- Tombol hapus hanya muncul jika tidak terkunci --}}
                <button x-show="!{{ $isLocked ? 'true' : 'false' }}" @click="deleteFile(file.id, index)" class="text-red-500 hover:text-red-700 ml-4">&times;</button>
            </div>
        </template>
    </div>
    <div x-show="uploadedFiles.length === 0 && {{ $isLocked ? 'true' : 'false' }}" class="mt-2">
        <p class="text-sm text-gray-500">Belum ada file yang diunggah.</p>
    </div>

    <!-- Dropzone dan Uploader (hanya muncul jika tidak terkunci) -->
    @if(!$isLocked)
    <div x-show="allowMultiple || uploadedFiles.length === 0">
        <!-- Dropzone -->
        <div @dragover.prevent="isDragging = true" @dragleave.prevent="isDragging = false" @drop.prevent="isDragging = false; handleFiles($event.dataTransfer.files)"
             class="mt-2 border-2 border-dashed rounded-lg p-6 text-center transition-colors"
             :class="{'border-indigo-500 bg-indigo-50': isDragging, 'border-gray-300': !isDragging}">
            <p class="text-sm text-gray-500">Seret file ke sini, atau <label :for="'file-{{ $requirement->id }}'" class="text-indigo-600 cursor-pointer hover:underline">pilih file</label></p>
            <input type="file" :id="'file-{{ $requirement->id }}'" @change="handleFiles($event.target.files)" class="hidden" accept=".pdf" :multiple="allowMultiple">
        </div>

        <!-- Daftar File Siap Unggah (Staged) -->
        <div x-show="stagedFiles.length > 0" class="mt-2 space-y-2">
            <template x-for="(file, index) in stagedFiles" :key="index">
                <div class="flex items-center justify-between bg-blue-50 p-2 rounded-md">
                    <p class="text-sm truncate"><i class="fa-solid fa-clock mr-2"></i><span x-text="file.name"></span></p>
                    <button @click="removeStagedFile(index)" class="text-gray-500 hover:text-gray-700 ml-4">&times;</button>
                </div>
            </template>
        </div>

        <!-- Progress Bar & Tombol Unggah -->
        <div x-show="stagedFiles.length > 0" class="mt-4">
            <div x-show="uploading" class="w-full bg-gray-200 rounded-full h-2.5 mb-2"><div class="bg-indigo-600 h-2.5 rounded-full" :style="`width: ${progress}%`"></div></div>
            <button @click="uploadAll()" :disabled="uploading" class="w-full px-4 py-2 text-sm text-white bg-indigo-600 rounded-md hover:bg-indigo-700 disabled:bg-indigo-300">
                Unggah <span x-text="stagedFiles.length"></span> File Dipilih
            </button>
        </div>
    </div>
    @endif
</div>