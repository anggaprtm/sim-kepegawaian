<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id',
        'nama_dokumen',
        'path_file',
    ];

    public function submission()
    {
        return $this->belongsTo(PromotionSubmission::class, 'submission_id');
    }
}
