<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('benda_sejarah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zona_id')->constrained('zona')->onDelete('cascade');
            $table->string('nama_benda', 150);
            $table->text('deskripsi')->nullable();
            $table->string('foto', 255)->nullable();
            $table->string('audio', 255)->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('benda_sejarah');
    }
};
