<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainsTable extends Migration
{
    public function up(): void
    {
    Schema::create('trains', function (Blueprint $table) {
 $table->id();
 $table->string('name');
    $table->string('number')->unique();
    $table->enum('type', ['express', 'local', 'intercity', 'mail']);
        $table->integer('total_coaches');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trains');
    }
}
