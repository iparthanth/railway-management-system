<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_station_id')->constrained('stations')->onDelete('cascade');
            $table->foreignId('to_station_id')->constrained('stations')->onDelete('cascade');
            $table->integer('distance_km');
            $table->decimal('base_fare', 8, 2);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->unique(['from_station_id', 'to_station_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};