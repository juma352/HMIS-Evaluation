<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\VendorEvaluation;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing 'Form B' evaluations with a null evaluation_date
        // Set evaluation_date to created_at if it's null for Form B
        VendorEvaluation::where('form_type', 'B')
            ->whereNull('evaluation_date')
            ->each(function (VendorEvaluation $evaluation) {
                $evaluation->evaluation_date = $evaluation->created_at->toDateString();
                $evaluation->save();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert changes if necessary (e.g., set evaluation_date back to null for Form B)
        // This might not be desirable if the dates were manually corrected.
        // For simplicity, this down method does nothing, assuming you want to keep the corrected dates.
        // If you need to revert, you would implement the logic here.
    }
};
