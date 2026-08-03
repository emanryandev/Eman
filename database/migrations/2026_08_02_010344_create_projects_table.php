<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('category')->default('all');
            $table->text('description')->nullable();
            $table->string('role')->nullable();
            $table->json('tech_stack')->nullable();
            $table->string('repository_url')->nullable();
            $table->string('live_url')->nullable();
            $table->string('image_url')->nullable();
            $table->integer('display_order')->default(99);
            $table->json('ui_config')->nullable();
            $table->string('status')->default('published');
            $table->integer('claps')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
