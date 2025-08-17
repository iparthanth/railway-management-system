<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoachesTable extends Migration
{
    public function up(): void
 {
 Schema::create('coaches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('train_id')->constrained('trains')->onDelete('cascade');
            $table->string('coach_number');
            $table->enum('coach_type', ['economy', 'business', 'first_class', 'sleeper']);
            $table->integer('total_seats');
            $table->integer('capacity')->virtualAs('total_seats');
            $table->decimal('price_multiplier', 3, 2)->default(1.00);
            $table->timestamps();
 });
 }

    public function down(): void
    {
        Schema::dropIfExists('coaches');
    }
}
