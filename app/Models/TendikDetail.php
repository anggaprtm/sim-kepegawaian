<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TendikDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir',
        'jabatan', 'status_kepegawaian', 'alamat', 'no_hp'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}