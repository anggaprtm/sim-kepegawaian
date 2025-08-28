<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PakSession extends Model {
    use HasFactory;
    protected $fillable = ['nama_sesi', 'tanggal_sidang', 'notula', 'status'];
    public function submissions() {
        return $this->belongsToMany(PromotionSubmission::class, 'pak_session_submissions', 'pak_session_id', 'submission_id');
    }
}