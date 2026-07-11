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
        Schema::create('debts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['payable', 'receivable']); // payable = saya ngutang, receivable = orang ngutang
            $table->string('person_name');
            $table->decimal('amount', 15, 2);
            $table->decimal('amount_paid', 15, 2)->default(0);
            $table->date('due_date')->nullable();
            $table->enum('status', ['unpaid', 'partially_paid', 'paid'])->default('unpaid');
            $table->string('account')->default('cash'); // Where the money came from/went to initially
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debts');
    }
};
