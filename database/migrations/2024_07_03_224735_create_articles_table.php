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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('writer_id')->nullable();
            $table->string('thumbnail_sm_url', 255)->nullable(false);
            $table->string('thumbnail_lg_url', 255)->nullable(false);
            $table->string('title', 150)->nullable(false);
            $table->mediumText('content')->nullable(false);
            $table->enum('status', ['published', 'draft'])->default('published')->nullable(false);
            $table->timestamps();

            $table->foreign('writer_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
