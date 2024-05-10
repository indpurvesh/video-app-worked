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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string("api_video_id")->nullable();
            $table->string("local_path")->nullable();

            $table->string("title")->nullable();
            $table->string("description")->nullable();
            $table->string("player")->nullable();
            $table->string("thumbnail")->nullable();

            $table->string("status")->nullable();
            $table->string("user_id");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
