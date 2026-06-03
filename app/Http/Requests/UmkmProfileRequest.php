<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UmkmProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_usaha' => 'required|string|max:255',
            'kategori_id' => 'required|exists:categories,id',
            'kecamatan_id' => 'required|exists:districts,id',
            'deskripsi' => 'required|string|max:1000',
            'whatsapp' => 'required|string|regex:/^[0-9]{10,15}$/',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_usaha.required' => 'Nama usaha wajib diisi',
            'kategori_id.required' => 'Kategori wajib dipilih',
            'kecamatan_id.required' => 'Kecamatan wajib dipilih',
            'deskripsi.required' => 'Deskripsi wajib diisi',
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi',
            'whatsapp.regex' => 'Format nomor WhatsApp tidak valid (10-15 digit)',
            'logo.image' => 'Logo harus berupa gambar',
            'logo.max' => 'Ukuran logo maksimal 2MB',
            'photos.*.image' => 'File harus berupa gambar',
            'photos.*.max' => 'Ukuran foto maksimal 2MB',
        ];
    }
}
