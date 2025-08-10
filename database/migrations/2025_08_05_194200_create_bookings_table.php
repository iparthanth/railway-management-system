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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('train_id')->constrained()->onDelete('cascade');
            $table->foreignId('route_id')->constrained()->onDelete('cascade');
            $table->string('booking_reference', 20)->unique();
            $table->string('passenger_name', 100);
            $table->string('passenger_email', 100);
            $table->string('passenger_phone', 20);
            $table->string('passenger_nid', 20)->nullable();
            $table->date('travel_date');
            $table->enum('seat_class', ['AC_B', 'AC_S', 'SNIGDHA', 'F_BERTH', 'F_SEAT', 'S_CHAIR'])->default('S_CHAIR');
            $table->decimal('total_amount', 10, 2);
            $table->enum('payment_status', ['PENDING', 'PAID', 'FAILED', 'REFUNDED'])->default('PENDING');
            $table->enum('booking_status', ['CONFIRMED', 'CANCELLED', 'COMPLETED'])->default('CONFIRMED');
            $table->text('special_requests')->nullable();
            $table->timestamps();

            $table->index(['booking_reference']);
            $table->index(['user_id', 'booking_status']);
            $table->index(['travel_date', 'booking_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};