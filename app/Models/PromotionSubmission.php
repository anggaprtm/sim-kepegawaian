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
        // Ambil ID dari semua persyaratan yang WAJIB untuk jabatan fungsional tujuan
        $requiredRequirementIds = PromotionRequirement::where('jabatan_fungsional', $this->jabatan_fungsional_tujuan)
            ->where('is_wajib', true)
            ->pluck('id');

        // Jika tidak ada persyaratan wajib, maka dianggap lengkap
        if ($requiredRequirementIds->isEmpty()) {
            return true;
        }

        // Ambil ID persyaratan dari dokumen yang sudah diunggah untuk submission ini
        $uploadedRequirementIds = $this->documents()->pluck('promotion_requirement_id')->unique();

        // Cek apakah semua ID persyaratan yang wajib sudah ada di dalam daftar yang diunggah
        return $requiredRequirementIds->diff($uploadedRequirementIds)->isEmpty();
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
    
    public function logs()
    {
        return $this->hasMany(SubmissionLog::class, 'submission_id')->latest();
    }
}
