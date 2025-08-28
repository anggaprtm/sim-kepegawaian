<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'dosen_user_id',
        'jabatan_fungsional_sebelumnya',
        'jabatan_fungsional_tujuan',
        'status',
        'catatan_revisi',
        'catatan_penolakan',
    ];

    // Relasi ke user Dosen yang mengajukan
    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_user_id');
    }

    // Relasi ke dokumen-dokumen yang diunggah
    public function documents()
    {
        return $this->hasMany(SubmissionDocument::class, 'submission_id');
    }

    public function areDocumentsComplete(): bool
    {
        $requiredDocs = collect(config('promotion.requirements.' . $this->jabatan_fungsional_tujuan, []));
        $uploadedDocs = $this->documents()->pluck('nama_dokumen');

        // Cek apakah semua dokumen yang dibutuhkan sudah ada di koleksi dokumen yang diunggah
        return $requiredDocs->diff($uploadedDocs)->isEmpty();
    }

    public function assessors()
    {
        return $this->belongsToMany(User::class, 'assessor_assignments', 'submission_id', 'assessor_user_id')
                    ->withPivot('start_date', 'end_date')
                    ->withTimestamps();
    }

    public function pakSession() {
        return $this->belongsToMany(PakSession::class, 'pak_session_submissions');
    }

    public function bpfSession() {
        return $this->belongsToMany(BpfSession::class, 'bpf_session_submissions', 'submission_id', 'bpf_session_id');
    }

}
