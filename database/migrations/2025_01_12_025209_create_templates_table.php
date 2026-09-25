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
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            // Template
            $table->string('name')->unique();
            $table->string('image')->nullable();
            // Settings are grouped by section; defaults are supplied by Template.
            $table->json('background')->nullable();
            $table->json('head')->nullable();
            $table->json('gallery')->nullable();
            $table->json('desc')->nullable();
            $table->json('product')->nullable();
            $table->json('contact')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};
