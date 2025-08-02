<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('train_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('train_id')->constrained()->onDelete('cascade');
            $table->string('class_name'); // AC_B, AC_S, SNIGDHA, F_SEAT, etc.
            $table->decimal('base_fare', 8, 2);
            $table->integer('total_seats');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('train_classes');
    }
};
