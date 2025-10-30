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
        // Resize result column
        $table->string('result', 100)->change();

        // Add columns only if they don't exist
        if (!Schema::hasColumn('detection_history', 'bert_result')) {
            $table->string('bert_result')->nullable();
        }
        if (!Schema::hasColumn('detection_history', 'bert_confidence')) {
            $table->float('bert_confidence')->nullable();
        }
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detection_history', function (Blueprint $table) {
            $table->string('result', 50)->change(); // revert to previous length
            $table->dropColumn(['bert_result', 'bert_confidence']);
        });
    }
};
