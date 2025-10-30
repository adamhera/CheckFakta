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
        Schema::table('detection_history', function (Blueprint $table) {
            $table->string('final_result')->nullable()->after('bert_confidence');
            $table->float('hybrid_confidence')->nullable()->after('final_result');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detection_history', function (Blueprint $table) {
            //
        });
    }
};
