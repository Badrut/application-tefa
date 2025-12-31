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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();

            $table->foreignId('customer_id')->constrained('users');
            $table->foreignId('quotation_id')->nullable()->constrained('quotations');
            $table->foreignId('major_id')->constrained('majors');

            $table->date('order_date');
            $table->decimal('total_amount', 15, 2)->default(0);

            $table->enum('payment_status', [
                'pending', 'dp_paid', 'paid', 'refunded'
            ])->default('pending');

            $table->enum('order_status', [
                'new', 'confirmed', 'in_production', 'qc',
                'shipped', 'completed', 'cancelled'
            ])->default('new');

            $table->text('delivery_address')->nullable();
            $table->date('delivery_date')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
