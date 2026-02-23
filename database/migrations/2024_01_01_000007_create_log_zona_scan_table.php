<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_zona_scan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zona_id')->constrained('zona')->onDelete('cascade');
            $table->timestamp('scanned_at')->useCurrent();
            $table->string('ip_address', 45)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_zona_scan');
    }
};
