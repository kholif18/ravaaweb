<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ProductRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $productId = $this->route('product') ? $this->route('product')->id : null;

        return [
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100|unique:products,sku' . ($productId ? ',' . $productId : ''),
            'slug' => 'nullable|string|max:255|unique:products,slug' . ($productId ? ',' . $productId : ''),
            'description' => 'nullable|string',
            'specifications' => 'nullable|string', 
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required_unless:has_variants,1|nullable|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'discount_start_at' => 'nullable|date',
            'discount_end_at' => 'nullable|date|after_or_equal:discount_start_at',
            'stock_status' => 'required_unless:has_variants,1|nullable|in:in_stock,out_of_stock,pre_order',
            'weight' => 'nullable|numeric|min:0',
            'unit' => 'nullable|string|max:50',
            'length' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'is_best_seller' => 'boolean',
            'is_new_arrival' => 'boolean',
            'is_digital' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'main_media_id' => 'nullable|exists:media,id',
            'gallery_images' => 'nullable|string', 
            'has_variants' => 'boolean',
            'variant_attributes' => 'nullable|array', 
            'quick_infos' => 'nullable|array', 
            'tags' => 'nullable|array', 
            'variants' => 'required_if:has_variants,1|array',
            'variants.*.id' => 'nullable|integer',
            'variants.*.name' => 'required_if:has_variants,1|string|max:255',
            'variants.*.sku' => 'nullable|string|max:100',
            'variants.*.price' => 'required_if:has_variants,1|numeric|min:0',
            'variants.*.discount_price' => 'nullable|numeric|min:0',
            'variants.*.discount_start_at' => 'nullable|date',
            'variants.*.discount_end_at' => 'nullable|date|after_or_equal:variants.*.discount_start_at',
            'variants.*.stock_status' => 'required_if:has_variants,1|in:in_stock,out_of_stock,pre_order',
            'variants.*.weight' => 'nullable|numeric|min:0',
            'variants.*.unit' => 'nullable|string|max:50',
            'variants.*.is_default' => 'boolean',
            'variants.*.attribute_options' => 'nullable|string', 
            'variants.*.image_id' => 'nullable|integer|exists:media,id',
            'deleted_variants' => 'nullable|string', 
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama produk wajib diisi.',
            'price.required_unless' => 'Harga wajib diisi jika produk tidak memiliki varian.',
            'stock_status.required_unless' => 'Status stok wajib diisi jika produk tidak memiliki varian.',
            'variants.required_if' => 'Data varian wajib diisi jika produk memiliki varian.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => $this->slug ?: Str::slug($this->name),
            'is_featured' => $this->has('is_featured'),
            'is_best_seller' => $this->has('is_best_seller'),
            'is_new_arrival' => $this->has('is_new_arrival'),
            'is_digital' => $this->has('is_digital'),
            'has_variants' => $this->has('has_variants'),
        ]);
    }
}
