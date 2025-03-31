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
        Schema::create('message_leads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('advertiser_id')->nullable(); // If related to a user
            $table->string('name')->nullable();  // Name of the lead
            $table->string('email')->nullable(); // Email of the lead
            $table->string('phone')->nullable(); // Phone number
            $table->text('message');
            $table->text('url')->nullable(); // Message content;
            $table->text('current_guard')->nullable(); // Current guard
            $table->string('status')->default(0)->comment('0=pending, 1=working, 2=rejected,3=completed');

            $table->decimal('lead_amount', 12, 3)->default(0);
            $table->boolean('payment_status')->default(false);
            $table->text('lead_type')->nullable()->default(1)->comment('1:Paid, 2:Free');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_leads');
    }
};
