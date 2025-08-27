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
}
