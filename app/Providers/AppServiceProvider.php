<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\VendorEvaluation;

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
        Schema::defaultStringLength(191);
    }

    /**
     * Calculate the total score for a Form B evaluation.
     *
     * @param \App\Models\VendorEvaluation $evaluation
     * @return float
     */
    public static function calculateFormBScore(VendorEvaluation $evaluation): float
    {
        $totalScore = 0;
        $questionCount = 0;

        foreach (['a', 'b', 'c', 'd', 'e', 'f'] as $sectionKey) {
            $section = $evaluation->{'section_' . $sectionKey};
            if (is_array($section) && isset($section['ratings'])) {
                foreach ($section['ratings'] as $rating) {
                    if (isset($rating['score']) && is_numeric($rating['score'])) {
                        $totalScore += (int)$rating['score'];
                        $questionCount++;
                    }
                }
            }
        }

        if ($questionCount === 0) {
            return 0;
        }

        // Calculate the average score and scale it to 100.
        $averageScore = $totalScore / $questionCount;
        return ($averageScore / 5) * 100;
    }
}
