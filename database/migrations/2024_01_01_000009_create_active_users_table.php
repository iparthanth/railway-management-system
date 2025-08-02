<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('active_users', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->unique();
            $table->string('ip_address');
            $table->string('user_agent');
            $table->string('current_page');
            $table->json('search_params')->nullable();
            $table->timestamp('last_activity');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('active_users');
    }
};
