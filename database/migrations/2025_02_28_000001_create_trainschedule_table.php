<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // This migration file is no longer needed as stations are created in their own migration
        // Keeping for migration history consistency
    }

    public function down(): void
    {
        // No action needed
    }
};
