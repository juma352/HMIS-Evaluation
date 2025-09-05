<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('vendor_evaluations', function (Blueprint $table) {
         $table->renameColumn('meeting_date', 'evaluation_date');
         $table->json('section_a')->change();
            $table->json('section_b')->change();
            $table->json('section_c')->change();
            $table->json('section_d')->change();
            $table->json('section_e')->change();
            $table->json('section_f')->change();
             $table->text('areas_for_improvement')->nullable()->after('key_risks');
              $table->renameColumn('next_steps', 'final_comments');
             $table->decimal('total_score', 5, 2)->change();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendor_evaluations', function (Blueprint $table) {
            $table->renameColumn('evaluation_date', 'meeting_date');
            $table->dropColumn('areas_for_improvement');
            $table->renameColumn('final_comments', 'next_steps');
            // Revert JSON columns if needed
            $table->text('section_a')->change();
            $table->text('section_b')->change();
            $table->text('section_c')->change();
            $table->text('section_d')->change();
            $table->text('section_e')->change();
            $table->text('section_f')->change();
        });
    }
};
