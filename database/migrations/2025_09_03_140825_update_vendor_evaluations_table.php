<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vendor_evaluations', function (Blueprint $table) {
            $table->date('meeting_date')->nullable()->after('evaluator_name');
            $table->renameColumn('functional_capabilities', 'section_a');
            $table->renameColumn('technical_architecture', 'section_b');
            $table->renameColumn('integration_interoperability', 'section_c');
            $table->renameColumn('vendor_stability', 'section_d');
            $table->renameColumn('security_compliance', 'section_e');
            $table->renameColumn('total_cost_ownership', 'section_f');
        });
    }

    public function down(): void
    {
        Schema::table('vendor_evaluations', function (Blueprint $table) {
            $table->dropColumn('meeting_date');
            $table->renameColumn('section_a', 'functional_capabilities');
            $table->renameColumn('section_b', 'technical_architecture');
            $table->renameColumn('section_c', 'integration_interoperability');
            $table->renameColumn('section_d', 'vendor_stability');
            $table->renameColumn('section_e', 'security_compliance');
            $table->renameColumn('section_f', 'total_cost_ownership');
        });
    }
};