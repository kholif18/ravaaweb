<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHomeBannerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'button1_text' => 'required|string|max:50',
            'button1_link' => 'required|string|max:255',
            'button2_text' => 'required|string|max:50',
            'button2_link' => 'required|string|max:255',
            'status' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul banner harus diisi',
            'title.max' => 'Judul maksimal 255 karakter',
            'description.required' => 'Deskripsi banner harus diisi',
            'description.max' => 'Deskripsi maksimal 500 karakter',
            'banner_image.image' => 'File harus berupa gambar',
            'banner_image.mimes' => 'Format gambar yang didukung: jpeg, png, jpg, gif, webp',
            'banner_image.max' => 'Ukuran gambar maksimal 2MB',
            'button1_text.required' => 'Teks tombol 1 harus diisi',
            'button1_text.max' => 'Teks tombol 1 maksimal 50 karakter',
            'button1_link.required' => 'Link tombol 1 harus diisi',
            'button1_link.max' => 'Link tombol 1 maksimal 255 karakter',
            'button2_text.required' => 'Teks tombol 2 harus diisi',
            'button2_text.max' => 'Teks tombol 2 maksimal 50 karakter',
            'button2_link.required' => 'Link tombol 2 harus diisi',
            'button2_link.max' => 'Link tombol 2 maksimal 255 karakter',
        ];
    }
}
