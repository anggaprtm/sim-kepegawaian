<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionRequirement extends Model {
    use HasFactory;
    protected $fillable = ['jabatan_fungsional', 'nama_dokumen', 'is_wajib', 'allow_multiple_files'];

    protected $casts = [
        'is_wajib' => 'boolean',
        'allow_multiple_files' => 'boolean',
    ];

    public function documents()
    {
        return $this->hasMany(SubmissionDocument::class);
    }
}