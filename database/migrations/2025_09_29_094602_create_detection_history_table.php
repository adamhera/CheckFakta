<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('detection_history', function (Blueprint $table) {
            $table->id('history_id');
            $table->unsignedBigInteger('user_id');
            $table->text('news_text');
            $table->string('result');
            $table->timestamp('detected_at')->useCurrent();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detection_history');
    }
};
