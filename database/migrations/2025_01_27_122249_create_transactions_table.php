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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('advertiser_id');
            $table->decimal('amount', 12, 2);
            $table->decimal('old_balance', 12, 2);
            $table->decimal('new_balance', 12, 2);
            $table->string('status')->default(1);
            $table->string('transaction_id')->nullable();
            $table->string('income_type')->nullable()->comment('debit, credit');
            $table->longText('details')->nullable();
            $table->longText('guard')->nullable();
            $table->text('lead_type')->nullable();
            $table->string('order_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
