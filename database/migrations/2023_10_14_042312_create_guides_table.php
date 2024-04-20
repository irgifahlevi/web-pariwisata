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
        Schema::create('guides', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('guide_name');
            $table->string('descriptions')->nullable();
            $table->string('image_guide');
            $table->string('url_instagram')->nullable();
            $table->string('url_facebook')->nullable();
            $table->string('url_whatsapp')->nullable();
            $table->enum('row_status', ['0', '1'])->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guides');
    }
};
