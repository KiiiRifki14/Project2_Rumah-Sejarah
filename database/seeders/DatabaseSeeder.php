<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\SesiKunjungan;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat akun Admin
        Admin::create([
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'nama' => 'Administrator',
            'role' => 'admin',
        ]);

        // Buat akun Gatekeeper (Petugas)
        Admin::create([
            'username' => 'petugas',
            'password' => Hash::make('petugas123'),
            'nama' => 'Petugas Gerbang',
            'role' => 'gatekeeper',
        ]);

        // Buat Sesi Kunjungan Default
        SesiKunjungan::create([
            'nama_sesi' => 'Sesi Pagi',
            'jam_mulai' => '08:00',
            'jam_selesai' => '11:00',
            'kuota' => 50,
            'is_active' => true,
        ]);

        SesiKunjungan::create([
            'nama_sesi' => 'Sesi Siang',
            'jam_mulai' => '11:00',
            'jam_selesai' => '14:00',
            'kuota' => 50,
            'is_active' => true,
        ]);

        SesiKunjungan::create([
            'nama_sesi' => 'Sesi Sore',
            'jam_mulai' => '14:00',
            'jam_selesai' => '17:00',
            'kuota' => 50,
            'is_active' => true,
        ]);
    }
}
