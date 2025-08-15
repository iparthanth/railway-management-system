<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('train_routes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('train_id')->constrained('trains')->onDelete('cascade');
            $table->foreignId('route_id')->constrained('routes')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['train_id', 'route_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('train_routes');
    }
};