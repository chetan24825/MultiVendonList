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
        Schema::create('custompages', function (Blueprint $table) {
            $table->id();
            $table->string('page_name'); // Service name
            $table->string('parent_id')->default('0')->comment("Parent Id: 0"); // Parent ID, default '0'
            $table->string('sub_id')->default('0')->comment("Parent Id: 0"); // Sub ID, default '0'
            $table->string('slug')->nullable(); // Slug, nullable
            $table->string('banner')->nullable(); // Banner, nullable
            $table->longText('short_desc')->nullable(); // Short description, nullable
            $table->integer('status')->default(1)->comment("Status Draft: 0, Status Draft: 1"); // Status, default '1'
            $table->longText('page_desc')->nullable(); // Service description, nullable
            $table->string('priority')->default(1000);
            $table->string('Show_in')->default(1)->comment("Show in Both: 2, Show in header: 1, Show in footer: 0"); // Show in, default '1';
            $table->longText('meta_title')->nullable(); // Meta title, nullable
            $table->longText('meta_keyword')->nullable(); // Meta keyword, nullable
            $table->longText('meta_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custompages');
    }
};
