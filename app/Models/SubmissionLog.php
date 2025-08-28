<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id',
        'status_sebelumnya',
        'status_sekarang',
        'catatan',
        'processed_by_user_id',
    ];

    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by_user_id');
    }
}