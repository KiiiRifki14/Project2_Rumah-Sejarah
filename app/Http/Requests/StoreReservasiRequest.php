<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservasiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:100',
            'nik' => 'required|string|size:16',
            'whatsapp' => 'required|string|max:20',
            'email' => 'required|email|max:100',
            'jumlah_anggota' => 'required|integer|min:1|max:20',
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'sesi_id' => 'required|exists:sesi_kunjungan,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama wajib diisi.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.size' => 'NIK harus 16 digit.',
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'jumlah_anggota.required' => 'Jumlah anggota wajib diisi.',
            'jumlah_anggota.min' => 'Minimal 1 orang.',
            'jumlah_anggota.max' => 'Maksimal 20 orang per reservasi.',
            'tanggal_kunjungan.required' => 'Tanggal kunjungan wajib dipilih.',
            'tanggal_kunjungan.after_or_equal' => 'Tanggal tidak boleh di masa lalu.',
            'sesi_id.required' => 'Sesi kunjungan wajib dipilih.',
        ];
    }
}
