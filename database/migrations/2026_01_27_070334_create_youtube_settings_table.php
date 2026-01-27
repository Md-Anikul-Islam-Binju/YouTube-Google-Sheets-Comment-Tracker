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
        Schema::create('youtube_settings', function (Blueprint $table) {
            $table->id();
            $table->string('video_id');
            $table->string('live_chat_id')->nullable();
            $table->json('keywords'); // ["sold","buy"]
            $table->string('sheet_id');
            $table->string('page_token')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('youtube_settings');
    }
};
