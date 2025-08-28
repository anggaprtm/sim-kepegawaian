<?php

namespace App\Observers;

use App\Models\PromotionSubmission;
use App\Models\SubmissionLog;
use Illuminate\Support\Facades\Auth;

class PromotionSubmissionObserver
{
    /**
     * Handle the PromotionSubmission "updated" event.
     */
    public function updated(PromotionSubmission $promotionSubmission): void
    {
        // Cek jika kolom 'status' benar-benar berubah
        if ($promotionSubmission->isDirty('status')) {
            SubmissionLog::create([
                'submission_id' => $promotionSubmission->id,
                'status_sebelumnya' => $promotionSubmission->getOriginal('status'),
                'status_sekarang' => $promotionSubmission->status,
                'processed_by_user_id' => Auth::id(), // User yang sedang login
                'catatan' => $promotionSubmission->catatan_revisi ?? $promotionSubmission->catatan_penolakan,
            ]);
        }
    }
}
