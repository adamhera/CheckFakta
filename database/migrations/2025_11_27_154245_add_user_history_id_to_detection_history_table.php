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
            $table->unsignedBigInteger('user_history_id')->after('history_id')->default(0);
            $table->index(['user_id', 'user_history_id']); // optional, faster queries per user
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detection_history', function (Blueprint $table) {
            $table->dropColumn('user_history_id');
        });
    }
};
