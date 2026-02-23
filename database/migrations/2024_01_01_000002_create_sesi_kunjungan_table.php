<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sesi_kunjungan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sesi', 100);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->integer('kuota')->default(50);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sesi_kunjungan');
    }
};
