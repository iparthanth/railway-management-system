<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('pnr')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('train_id')->constrained();
            $table->foreignId('from_station_id')->constrained('stations');
            $table->foreignId('to_station_id')->constrained('stations');
            $table->date('journey_date');
            $table->string('class_name');
            $table->string('passenger_name');
            $table->enum('passenger_type', ['adult', 'child']);
            $table->string('mobile');
            $table->string('email');
            $table->decimal('fare', 8, 2);
            $table->decimal('vat', 8, 2)->default(0);
            $table->decimal('service_charge', 8, 2)->default(0);
            $table->decimal('total_amount', 8, 2);
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->string('seat_number')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};
