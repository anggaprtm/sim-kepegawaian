<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Undangan Sidang BPF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .content { margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <div class="header">
        <h3><u>UNDANGAN SIDANG BADAN PERTIMBANGAN FAKULTAS (BPF)</u></h3>
        <p>Nomor: .../.../.../{{ now()->year }}</p>
    </div>

    <div class="content">
        <p>Dengan hormat,</p>
        <p>Menindaklanjuti hasil Sidang PAK, kami mengundang Bapak/Ibu untuk hadir dalam Sidang Badan Pertimbangan Fakultas (BPF) yang akan diselenggarakan pada:</p>
        
        <p>
            <strong>Hari/Tanggal:</strong> {{ \Carbon\Carbon::parse($session->tanggal_sidang)->translatedFormat('l, d F Y') }} <br>
            <strong>Waktu:</strong> 13:00 WIB - Selesai <br>
            <strong>Tempat:</strong> Ruang Rapat Dekanat
        </p>

        <p>Adapun daftar nama Dosen yang akan dibahas dalam sidang ini adalah sebagai berikut:</p>
        <table>
            <thead>
                <tr style="background-color: #f2f2f2;">
                    <th>No</th>
                    <th>Nama Dosen</th>
                    <th>NIP</th>
                    <th>Jabatan Tujuan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($session->submissions as $submission)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ optional($submission->dosen)->name ?? 'dosen null' }}</td>
                        <td>{{ optional($submission->dosen)->nip ?? 'nip null' }}</td>
                        <td>{{ $submission->jabatan_fungsional_tujuan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <p style="margin-top: 20px;">Demikian undangan ini kami sampaikan. Atas perhatian dan kehadiran Bapak/Ibu, kami ucapkan terima kasih.</p>
    </div>
</body>
</html>
