<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class ServiceCategoryRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:7|regex:/^#[0-9A-F]{6}$/i',
            'is_active' => 'boolean',
            'order' => 'integer|min:0',
        ];

        // Untuk update, slug boleh tidak unik jika tidak diubah
        if ($this->isMethod('post')) {
            $rules['name'] .= '|unique:service_categories,name';
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $categoryId = $this->route('service_category');
            $rules['name'] .= '|unique:service_categories,name,' . $categoryId;
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama kategori wajib diisi',
            'name.unique' => 'Nama kategori sudah digunakan',
            'color.regex' => 'Format warna harus hex (#RRGGBB)',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('name') && !$this->has('slug')) {
            $this->merge([
                'slug' => Str::slug($this->name)
            ]);
        }
    }
}
