<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// app/Models/SuratTugas.php
class SuratTugas extends Model
{
    use HasFactory;

    protected $table = 'surat_tugas';

    protected $fillable = [
        'perihal',
        'nomor_surat',
        'tujuan_user_id',
        'keperluan',
        'tanggal_surat',
        'created_by_user_id',
    ];

    public function tujuan()
    {
        return $this->belongsTo(User::class, 'tujuan_user_id');
    }

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }
}
