<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vendor_evaluations', function (Blueprint $table) {
            $table->string('form_type')->default('A'); // 'A' or 'B'
        });
    }

    public function down(): void
    {
        Schema::table('vendor_evaluations', function (Blueprint $table) {
            $table->dropColumn('form_type');
        });
    }
};