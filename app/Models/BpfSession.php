<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BpfSession extends Model {
    use HasFactory;
    protected $fillable = ['nama_sesi', 'tanggal_sidang', 'notula', 'status'];
    public function submissions() {
        return $this->belongsToMany(PromotionSubmission::class, 'bpf_session_submissions', 'bpf_session_id', 'submission_id');
    }
}
