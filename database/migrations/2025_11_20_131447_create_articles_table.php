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

           // Foreign keys
           $table->foreignId('source_id')->constrained('sources')->cascadeOnDelete();
           $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();

           // Article fields
           $table->string('title');
           $table->text('description')->nullable();
           $table->longText('content')->nullable();
        
           $table->string('author')->nullable();
           $table->string('url')->unique();
           $table->string('image_url')->nullable();
           $table->timestamp('published_at')->nullable();

           $table->timestamps();

           // Indexes for search
           $table->index(['title', 'description']);
           $table->index('published_at');
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
