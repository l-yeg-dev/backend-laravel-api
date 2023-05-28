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
            $table->text('title');
            $table->longText('content');
            $table->string('article_id')->nullable();
            $table->text('url')->nullable();
            $table->text('image_url')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('source_id')->nullable();
            $table->foreignId('category_id')->nullable();
            $table->foreignId('author_id')->nullable();
            $table->datetime('published_at')->nullable();
            $table->timestamps();
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
