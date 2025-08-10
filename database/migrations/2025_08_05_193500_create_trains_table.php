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
        Schema::create('trains', function (Blueprint $table) {
            $table->id();
            $table->string('train_number', 10)->unique();
            $table->string('name', 100);
            $table->enum('type', ['EXPRESS', 'INTERCITY', 'LOCAL', 'MAIL', 'PASSENGER'])->default('EXPRESS');
            $table->integer('total_seats')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['train_number', 'is_active']);
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trains');
    }
};
