<!DOCTYPE html>
<html>
<head>
    <title>Surat Pengantar Usulan Kenaikan Jabatan</title>
    <style> body { font-family: DejaVu Sans, sans-serif; font-size: 12px; } .header { text-align: center; } </style>
</head>
<body>
    <div class="header">
        <h3>SURAT PENGANTAR</h3>
        <p>Nomor: .../.../.../{{ now()->year }}</p>
    </div>
    <div class="content">
        <p>Dengan hormat,</p>
        <p>Bersama ini kami sampaikan daftar nama Dosen yang diusulkan untuk mendapatkan penetapan kenaikan jabatan fungsional:</p>
        <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
            <thead>
                <tr style="background-color: #f2f2f2;">
                    <th style="border: 1px solid black; padding: 8px;">No</th>
                    <th style="border: 1px solid black; padding: 8px;">Nama / NIP</th>
                    <th style="border: 1px solid black; padding: 8px;">Jabatan Saat Ini</th>
                    <th style="border: 1px solid black; padding: 8px;">Jabatan Tujuan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($submissions as $key => $submission)
                <tr>
                    <td style="border: 1px solid black; padding: 8px;">{{ $key + 1 }}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{ $submission->dosen->name }} <br> NIP. {{ $submission->dosen->nip }}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{ $submission->jabatan_fungsional_sebelumnya ?? '-' }}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{ $submission->jabatan_fungsional_tujuan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <p style="margin-top: 20px;">Demikian surat pengantar ini kami sampaikan. Atas perhatian dan kerja sama Bapak/Ibu, kami ucapkan terima kasih.</p>
    </div>
</body>
</html>
