@if ($errors->any())
<div class="mb-4"><ul class="mt-3 list-disc list-inside text-sm text-red-600">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div><x-input-label for="nip" value="NIP" /><x-text-input id="nip" class="block mt-1 w-full" type="text" name="nip" :value="old('nip', $tendik->nip ?? '')" required /></div>
    <div><x-input-label for="name" value="Nama Lengkap" /><x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $tendik->name ?? '')" required /></div>
    <div class="md:col-span-2"><x-input-label for="email" value="Email" /><x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $tendik->email ?? '')" required /></div>
    <div><x-input-label for="password" value="Password" /><x-text-input id="password" class="block mt-1 w-full" type="password" name="password" />@if (isset($tendik))<small class="text-gray-500">Kosongkan jika tidak ingin mengubah.</small>@endif</div>
    <div><x-input-label for="password_confirmation" value="Konfirmasi Password" /><x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" /></div>
    <div><x-input-label for="jenis_kelamin" value="Jenis Kelamin" /><select name="jenis_kelamin" id="jenis_kelamin" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"><option value="Laki-laki" @selected(old('jenis_kelamin', $tendik->tendikDetail->jenis_kelamin ?? '') == 'Laki-laki')>Laki-laki</option><option value="Perempuan" @selected(old('jenis_kelamin', $tendik->tendikDetail->jenis_kelamin ?? '') == 'Perempuan')>Perempuan</option></select></div>
    <div><x-input-label for="tempat_lahir" value="Tempat Lahir" /><x-text-input id="tempat_lahir" class="block mt-1 w-full" type="text" name="tempat_lahir" :value="old('tempat_lahir', $tendik->tendikDetail->tempat_lahir ?? '')" required /></div>
    <div><x-input-label for="tanggal_lahir" value="Tanggal Lahir" /><x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date" name="tanggal_lahir" :value="old('tanggal_lahir', $tendik->tendikDetail->tanggal_lahir ?? '')" required /></div>
    <div><x-input-label for="no_hp" value="No. HP" /><x-text-input id="no_hp" class="block mt-1 w-full" type="text" name="no_hp" :value="old('no_hp', $tendik->tendikDetail->no_hp ?? '')" required /></div>
    <div><x-input-label for="jabatan" value="Jabatan" /><x-text-input id="jabatan" class="block mt-1 w-full" type="text" name="jabatan" :value="old('jabatan', $tendik->tendikDetail->jabatan ?? '')" required /></div>
    <div><x-input-label for="status_kepegawaian" value="Status Kepegawaian" /><x-text-input id="status_kepegawaian" class="block mt-1 w-full" type="text" name="status_kepegawaian" :value="old('status_kepegawaian', $tendik->tendikDetail->status_kepegawaian ?? '')" required /></div>
    <div class="md:col-span-2"><x-input-label for="alamat" value="Alamat" /><textarea id="alamat" name="alamat" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('alamat', $tendik->tendikDetail->alamat ?? '') }}</textarea></div>
</div>