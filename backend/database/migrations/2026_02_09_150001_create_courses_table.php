<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instructor_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('short_description')->nullable();
            $table->decimal('price', 8, 2);
            $table->string('thumbnail')->nullable();
            $table->enum('level', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            $table->enum('status', ['draft', 'pending', 'published', 'rejected'])->default('draft');
            $table->integer('duration_minutes')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
