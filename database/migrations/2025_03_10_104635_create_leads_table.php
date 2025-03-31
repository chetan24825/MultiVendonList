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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('guard');
            $table->string('title');
            $table->string('title_slug')->nullable();
            $table->string('description')->nullable();
            $table->string('browse')->nullable();
            $table->decimal('start_range', 13, 2);
            $table->decimal('end_range', 13, 2);
            $table->string('status')->default(1)->comment('0=Published, 1=Unpublished');
            // $table->string('leads_type')->default(1)->comment('0=pannel, 1=message');
            $table->string('status_workflow')->default(0)->comment('0=pending, 1=working, 2=rejected,3=completed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
