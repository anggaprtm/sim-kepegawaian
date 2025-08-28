<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\PromotionSubmission; // <-- Import model
use App\Observers\PromotionSubmissionObserver; // <-- Import observer

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        PromotionSubmission::observe(PromotionSubmissionObserver::class);
    }
}
