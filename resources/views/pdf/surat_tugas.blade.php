<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Tugas Penilaian</title>
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
        <h3>SURAT TUGAS</h3>
        <p>Nomor: .../.../.../{{ now()->year }}</p>
    </div>
    <div class="content">
        <p>Berdasarkan hasil verifikasi berkas pengajuan kenaikan jabatan fungsional, dengan ini kami menugaskan:</p>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Asesor</th>
                    <th>NIP</th>
                </tr>
            </thead>
            <tbody>
                @foreach($submission->assessors as $key => $assessor)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $assessor->name }}</td>
                    <td>{{ $assessor->nip }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <p>Untuk melakukan penilaian angka kredit atas nama:</p>
        <p><strong>Nama:</strong> {{ $submission->dosen->name }}</p>
        <p><strong>NIP:</strong> {{ $submission->dosen->nip }}</p>
        <p><strong>Jabatan Usulan:</strong> {{ $submission->jabatan_fungsional_tujuan }}</p>

        <p>Penilaian dilaksanakan pada tanggal 
        <strong>{{ \Carbon\Carbon::parse($submission->assessors->first()->pivot->start_date)->format('d M Y') }}</strong> 
        s.d. 
        <strong>{{ \Carbon\Carbon::parse($submission->assessors->first()->pivot->end_date)->format('d M Y') }}</strong>.</p>
        
        <p>Demikian surat tugas ini dibuat untuk dapat dilaksanakan dengan sebaik-baiknya.</p>
    </div>
</body>
</html>
