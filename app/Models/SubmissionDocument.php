<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id',
        'promotion_requirement_id',
        'path_file',
    ];

    public function submission()
    {
        return $this->belongsTo(PromotionSubmission::class, 'submission_id');
    }

    public function requirement()
    {
        return $this->belongsTo(PromotionRequirement::class, 'promotion_requirement_id');
    }
}
