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
        Schema::create('vendor_evaluations', function (Blueprint $table) {
            $table->id();
            $table->string('vendor_name');
            $table->string('evaluator_name');
            $table->json('functional_capabilities')->nullable();
            $table->json('technical_architecture')->nullable();
            $table->json('integration_interoperability')->nullable();
            $table->json('vendor_stability')->nullable();
            $table->json('security_compliance')->nullable();
            $table->json('total_cost_ownership')->nullable();
            $table->text('key_strengths')->nullable();
            $table->text('key_risks')->nullable();
            $table->string('recommendation');
            $table->text('next_steps')->nullable();
            $table->float('total_score')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_evaluations');
    }
};
