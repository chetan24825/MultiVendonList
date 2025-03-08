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
        Schema::create('advertisers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();

            $table->string('company_name')->nullable();
            $table->string('phone2')->nullable();
            $table->string('technologies')->nullable();
            $table->string('type')->nullable()->comment('Individual: 1, Company: 2');
            $table->longText('address')->nullable();

            $table->string('email')->unique()->nullable();
            $table->string('avatar')->nullable();
            $table->string('phone')->nullable();
            $table->tinyInteger('status')->default(1);  // status 0 => inactive , 1 => active
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisers');
    }
};
