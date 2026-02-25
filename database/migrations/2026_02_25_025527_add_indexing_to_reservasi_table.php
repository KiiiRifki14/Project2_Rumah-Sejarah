<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reservasi', function (Blueprint $table) {
            $table->index('kode_tiket');
            $table->index('nik');
            $table->index(['tanggal_kunjungan', 'sesi_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservasi', function (Blueprint $table) {
            $table->dropIndex(['kode_tiket']);
            $table->dropIndex(['nik']);
            $table->dropIndex(['tanggal_kunjungan', 'sesi_id']);
        });
    }
};
