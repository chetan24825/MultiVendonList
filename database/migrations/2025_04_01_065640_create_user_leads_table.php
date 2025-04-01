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
        Schema::create('user_leads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('advertiser_id')->nullable();
            $table->unsignedBigInteger('lead_id')->nullable();
            $table->decimal('lead_amount', 12, 3)->default(0);
            $table->boolean('payment_status')->default(false);
            $table->text('guard')->nullable();
            $table->text('lead_type')->default(1)->comment('1:Paid, 2:Free');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_leads');
    }
};
