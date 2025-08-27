<!-- Menampilkan error validasi -->
@if ($errors->any())
    <div class="mb-4">
        <div class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div>
        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- NIP -->
    <div>
        <x-input-label for="nip" :value="__('NIP')" />
        <x-text-input id="nip" class="block mt-1 w-full" type="text" name="nip" :value="old('nip', $dosen->nip ?? '')" required autofocus />
    </div>

    <!-- Nama Lengkap -->
    <div>
        <x-input-label for="name" :value="__('Nama Lengkap')" />
        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $dosen->name ?? '')" required />
    </div>

    <!-- Email -->
    <div class="md:col-span-2">
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $dosen->email ?? '')" required />
    </div>

    <!-- Password -->
    <div>
        <x-input-label for="password" :value="__('Password')" />
        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" />
        @if (isset($dosen))
            <small class="text-gray-500">Kosongkan jika tidak ingin mengubah password.</small>
        @endif
    </div>

    <!-- Konfirmasi Password -->
    <div>
        <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" />
    </div>

    <!-- Jenis Kelamin -->
    <div>
        <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
        <select name="jenis_kelamin" id="jenis_kelamin" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
            <option value="Laki-laki" @selected(old('jenis_kelamin', $dosen->dosenDetail->jenis_kelamin ?? '') == 'Laki-laki')>Laki-laki</option>
            <option value="Perempuan" @selected(old('jenis_kelamin', $dosen->dosenDetail->jenis_kelamin ?? '') == 'Perempuan')>Perempuan</option>
        </select>
    </div>

    <!-- Tempat Lahir -->
    <div>
        <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" />
        <x-text-input id="tempat_lahir" class="block mt-1 w-full" type="text" name="tempat_lahir" :value="old('tempat_lahir', $dosen->dosenDetail->tempat_lahir ?? '')" required />
    </div>

    <!-- Tanggal Lahir -->
    <div>
        <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
        <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date" name="tanggal_lahir" :value="old('tanggal_lahir', $dosen->dosenDetail->tanggal_lahir ?? '')" required />
    </div>

    <!-- No HP -->
    <div>
        <x-input-label for="no_hp" :value="__('No. HP')" />
        <x-text-input id="no_hp" class="block mt-1 w-full" type="text" name="no_hp" :value="old('no_hp', $dosen->dosenDetail->no_hp ?? '')" required />
    </div>

    <!-- Status Kepegawaian -->
    <div>
        <x-input-label for="status_kepegawaian" :value="__('Status Kepegawaian')" />
        <x-text-input id="status_kepegawaian" class="block mt-1 w-full" type="text" name="status_kepegawaian" :value="old('status_kepegawaian', $dosen->dosenDetail->status_kepegawaian ?? '')" required />
    </div>

    <!-- Homebase Prodi -->
    <div>
        <x-input-label for="homebase_prodi" :value="__('Homebase Program Studi')" />
        <x-text-input id="homebase_prodi" class="block mt-1 w-full" type="text" name="homebase_prodi" :value="old('homebase_prodi', $dosen->dosenDetail->homebase_prodi ?? '')" required />
    </div>

    <!-- Jabatan Fungsional Saat Ini -->
    <div class="md:col-span-2">
        <x-input-label for="jabatan_fungsional_saat_ini" :value="__('Jabatan Fungsional Saat Ini')" />
        <x-text-input id="jabatan_fungsional_saat_ini" class="block mt-1 w-full" type="text" name="jabatan_fungsional_saat_ini" :value="old('jabatan_fungsional_saat_ini', $dosen->dosenDetail->jabatan_fungsional_saat_ini ?? '')" />
    </div>
    
    <!-- Alamat -->
    <div class="md:col-span-2">
        <x-input-label for="alamat" :value="__('Alamat')" />
        <textarea id="alamat" name="alamat" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('alamat', $dosen->dosenDetail->alamat ?? '') }}</textarea>
    </div>
</div>
