<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('train_id')->constrained('trains')->onDelete('cascade');
            $table->string('seat_number');
            $table->date('journey_date');
            $table->enum('status', ['available', 'booked'])->default('available');
            $table->timestamps();
            
            $table->index(['train_id', 'journey_date']);
            $table->unique(['train_id', 'seat_number', 'journey_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
