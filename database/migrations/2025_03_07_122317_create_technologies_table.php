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
        Schema::create('technologies', function (Blueprint $table) {
            $table->id();
            $table->string('name');         // Name of the technology
            $table->string('slug')->nullable();         // Slug for URLs (optional)
            $table->longText('description')->nullable();
            $table->string('image')->nullable();     // Image URL or path
            $table->string('status')->default(1); // Status (e.g., 'active', 'inactive')
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technologies');
    }
};
