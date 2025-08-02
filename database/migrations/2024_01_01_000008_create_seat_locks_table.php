<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('seat_locks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seat_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('journey_date');
            $table->timestamp('locked_until');
            $table->string('session_id');
            $table->timestamps();
            
            $table->unique(['seat_id', 'journey_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('seat_locks');
    }
};
