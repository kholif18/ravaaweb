{{-- resources/views/admin/products/partials/_tags_seo.blade.php --}}
<div class="card mb-5">
    <div class="card-header">
        <h4 class="card-title">Tags</h4>
    </div>
    <div class="card-body">
        <div class="mb-0">
            <label class="form-label">Tags Produk</label>
            <input type="text" class="form-control" 
                   name="tags" 
                   value="{{ old('tags', isset($product) && !empty($product->tags) ? (is_array($product->tags) ? implode(', ', $product->tags) : $product->tags) : '') }}"
                   placeholder="tag1, tag2, tag3" />
            <div class="text-muted fs-7 mt-1">Pisahkan dengan koma. Tags membantu pencarian produk di frontend.</div>
        </div>
    </div>
</div>

<div class="card mb-5">
    <div class="card-header">
        <h4 class="card-title">SEO Settings</h4>
    </div>
    <div class="card-body">
        <div class="mb-5">
            <label class="form-label">Meta Title</label>
            <input type="text" class="form-control" 
                   name="meta_title" 
                   value="{{ old('meta_title', $product->meta_title ?? '') }}"
                   placeholder="Meta title untuk SEO" />
        </div>
        
        <div class="mb-0">
            <label class="form-label">Meta Description</label>
            <textarea class="form-control" 
                      name="meta_description" 
                      rows="3"
                      placeholder="Meta description untuk SEO">{{ old('meta_description', $product->meta_description ?? '') }}</textarea>
        </div>
    </div>
</div>
