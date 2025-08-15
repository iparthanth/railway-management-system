<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trainstatus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('train_id')->constrained('trains')->onDelete('cascade');
            $table->date('date');
            $table->string('current_station');
            $table->string('status');
            $table->timestamp('last_updated');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trainstatus');
    }
};