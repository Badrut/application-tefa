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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->string('payment_code')->unique();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();

            $table->enum('payment_method', ['transfer', 'cash', 'qris', 'ewallet']);
            $table->decimal('amount', 15, 2);

            $table->enum('payment_type', ['dp', 'installment', 'full_payment']);
            $table->date('payment_date');

            $table->string('proof_url')->nullable();

            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');

            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->timestamp('verified_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
