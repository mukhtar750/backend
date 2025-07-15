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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', ['document', 'video', 'image', 'template', 'article', 'announcement']);
            $table->unsignedBigInteger('category_id')->nullable();
            $table->enum('visibility', ['public', 'entrepreneurs', 'mentors', 'investors', 'admin'])->default('public');
            $table->text('description')->nullable();
            $table->string('tags')->nullable(); // comma-separated or JSON
            $table->string('file_path')->nullable();
            $table->string('file_type')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->enum('status', ['draft', 'published', 'pending', 'rejected'])->default('pending');
            $table->unsignedBigInteger('user_id');
            $table->boolean('is_featured')->default(false);
            $table->unsignedBigInteger('views')->default(0);
            $table->unsignedBigInteger('downloads')->default(0);
            $table->float('rating')->default(0);
            $table->unsignedBigInteger('comments_count')->default(0);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->nullOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
