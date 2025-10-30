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
        $table->float('svm_confidence')->nullable()->after('result');        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detection_history', function (Blueprint $table) {
            $table->dropColumn('svm_confidence');
        });
    }
};
