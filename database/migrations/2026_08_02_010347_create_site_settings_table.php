<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('years_experience')->default(5);
            $table->integer('uptime_percentage')->default(99);
            $table->string('hero_title_en')->nullable();
            $table->string('hero_title_ar')->nullable();
            $table->text('about_en')->nullable();
            $table->text('about_ar')->nullable();
            $table->string('currently_learning_name')->nullable();
            $table->string('currently_learning_icon')->nullable();
            $table->string('profile_pic')->nullable();
            $table->json('core_skills')->nullable();
            $table->json('hobbies')->nullable();
            $table->json('radar_skills')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->json('testimonials')->nullable();
            $table->json('experience_journey')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
