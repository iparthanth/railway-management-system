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
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('train_id')->constrained()->onDelete('cascade');
            $table->foreignId('departure_station_id')->constrained('stations')->onDelete('cascade');
            $table->foreignId('arrival_station_id')->constrained('stations')->onDelete('cascade');
            $table->time('departure_time');
            $table->time('arrival_time');
            $table->decimal('distance_km', 8, 2)->default(0);
            $table->integer('duration_minutes')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['train_id', 'departure_station_id', 'arrival_station_id']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};
