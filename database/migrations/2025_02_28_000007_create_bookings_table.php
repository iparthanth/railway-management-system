<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('pnr', 20)->unique();
            $table->string('passenger_name');
            $table->string('passenger_email')->nullable();
            $table->string('passenger_phone', 20)->nullable();
            $table->foreignId('train_id')->constrained('trains')->onDelete('cascade');
            $table->foreignId('route_id')->constrained('routes')->onDelete('cascade');
            $table->date('journey_date');
            $table->json('selected_seats');
            $table->decimal('total_fare', 10, 2);
            
            // Payment fields
            $table->enum('payment_method', ['stripe', 'cash'])->default('stripe');
            $table->string('transaction_id')->nullable(); 
            $table->string('stripe_payment_intent_id')->nullable(); 
            $table->enum('payment_status', ['pending', 'succeeded', 'failed'])->default('pending');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade'); 
            
            $table->enum('booking_status', ['confirmed', 'cancelled'])->default('confirmed');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
