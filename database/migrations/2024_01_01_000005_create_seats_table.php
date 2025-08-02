<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('train_id')->constrained()->onDelete('cascade');
            $table->string('class_name');
            $table->string('coach_name'); // e.g., 'KHA', 'GA', 'CHA'
            $table->string('seat_number'); // e.g., '21', '20'
            $table->string('full_seat_number'); // e.g., 'KHA-21', 'KHA-20'
            $table->boolean('is_available')->default(true);
            $table->timestamps();
            
            $table->unique(['train_id', 'class_name', 'full_seat_number']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('seats');
    }
};
