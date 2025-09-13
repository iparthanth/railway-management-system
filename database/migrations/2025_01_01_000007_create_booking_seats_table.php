<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('booking_seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            // Seat can be nullable if label did not resolve to an ID, but we still keep a row for the passenger
            $table->foreignId('seat_id')->nullable()->constrained('seats')->nullOnDelete();
            $table->string('passenger_name');
            $table->integer('passenger_age')->nullable();
            $table->string('passenger_gender')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_seats');
    }
};
