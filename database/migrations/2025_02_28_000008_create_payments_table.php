<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Nullable for guest payments
            $table->foreignId('booking_id')->constrained()->onDelete('cascade'); // Link to booking
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('USD'); // Currency code
            $table->enum('payment_method', ['stripe', 'cash'])->default('stripe');
            $table->string('stripe_payment_intent_id')->nullable(); // Stripe Payment Intent ID
            $table->string('stripe_customer_id')->nullable(); // Stripe Customer ID (for saved customers)
            $table->string('transaction_id')->unique(); // Internal transaction ID
            $table->enum('status', ['pending', 'succeeded', 'failed'])->default('pending');
            $table->string('failure_reason')->nullable(); // Payment failure reason
            $table->timestamp('paid_at')->nullable(); // Payment completion time
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
