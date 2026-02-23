<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rate_limits', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45);
            $table->string('action', 50);
            $table->integer('attempts')->default(1);
            $table->timestamp('window_start')->useCurrent();

            $table->index(['ip_address', 'action']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rate_limits');
    }
};
