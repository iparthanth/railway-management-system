<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('train_id')->constrained()->onDelete('cascade');
            $table->foreignId('station_id')->constrained()->onDelete('cascade');
            $table->integer('sequence');
            $table->time('arrival_time')->nullable();
            $table->time('departure_time');
            $table->integer('halt_duration')->default(0); // in minutes
            $table->decimal('distance_from_origin', 8, 2)->default(0);
            $table->timestamps();
            
            $table->unique(['train_id', 'station_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('routes');
    }
};
