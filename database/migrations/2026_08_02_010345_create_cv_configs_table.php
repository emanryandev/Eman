<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cv_configs', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);
            $table->json('personal_info')->nullable();
            $table->text('summary')->nullable();
            $table->json('skills')->nullable();
            $table->json('experience')->nullable();
            $table->json('education')->nullable();
            $table->json('certifications')->nullable();
            $table->json('layout_preferences')->nullable();
            $table->string('custom_cv_url')->nullable();
            $table->integer('downloads')->default(0);
            $table->json('downloads_history')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cv_configs');
    }
};
