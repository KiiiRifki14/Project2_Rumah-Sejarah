<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservasi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode_tiket', 50)->unique();
            $table->string('nama', 100);
            $table->string('nik', 16);
            $table->string('whatsapp', 20);
            $table->string('email', 100);
            $table->integer('jumlah_anggota')->default(1);
            $table->date('tanggal_kunjungan');
            $table->foreignId('sesi_id')->constrained('sesi_kunjungan')->onDelete('cascade');
            $table->string('qr_code_path', 255)->nullable();
            $table->enum('status', ['pending', 'valid', 'telah_berkunjung'])->default('valid');
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservasi');
    }
};
