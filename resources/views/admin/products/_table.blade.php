@php
    $perPage = request('per_page', 15);
@endphp

<div class="table-responsive">
    <table class="table align-middle mb-0" id="kt_products_table">
        <thead>
            <tr>
                <th style="width: 32px;">
                    <div class="form-check" style="margin: 0;">
                        <input class="form-check-input" type="checkbox" id="select-all-products">
                    </div>
                </th>
                <th style="min-width: 200px;">Produk</th>
                <th style="min-width: 100px;">Kategori</th>
                <th style="min-width: 100px;">Harga</th>
                <th style="width: 60px;">Stok</th>
                <th style="width: 70px;">Status</th>
                <th style="width: 70px;" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>
                        <div class="form-check" style="margin: 0;">
                            <input class="form-check-input" type="checkbox" value="{{ $product->id }}">
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if($product->thumbnail)
                                <img src="{{ $product->thumbnail->url }}" alt="{{ $product->name }}" class="product-thumb">
                            @else
                                <div class="product-thumb-placeholder"><i class="bi bi-image"></i></div>
                            @endif
                            <div>
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-hover-primary fw-semibold" style="color: var(--text-primary); text-decoration: none; font-size: 0.82rem;">
                                    {{ Str::limit($product->name, 40) }}
                                </a>
                                @if($product->sku)
                                    <div style="font-size: 0.7rem; color: var(--text-muted);">SKU: {{ $product->sku }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge" style="background: rgba(var(--accent-rgb, 79,110,247), 0.1); color: var(--accent); font-size: 0.7rem; font-weight: 500;">
                            {{ $product->category->name ?? '-' }}
                        </span>
                    </td>
                    <td>
                        @if($product->variants_count > 0 && $product->variants->count() > 0)
                            @php
                                $prices = $product->variants->map(fn($v) => (float) ($v->price_discount > 0 ? $v->price_discount : $v->price));
                                $minPrice = $prices->min();
                                $maxPrice = $prices->max();
                            @endphp
                            <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-primary);">
                                @if($minPrice == $maxPrice)
                                    Rp {{ number_format($minPrice, 0, ',', '.') }}
                                @else
                                    Rp {{ number_format($minPrice, 0, ',', '.') }} - {{ number_format($maxPrice, 0, ',', '.') }}
                                @endif
                            </div>
                        @elseif($product->price_discount)
                            <div style="font-size: 0.72rem; color: var(--text-muted); text-decoration: line-through;">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                            <div style="font-size: 0.8rem; font-weight: 600; color: var(--danger, #ef4444);">Rp {{ number_format($product->price_discount, 0, ',', '.') }}</div>
                        @else
                            <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-primary);">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        @endif
                    </td>
                    <td>
                        @if($product->stock > 0)
                            <span class="badge" style="background: rgba(34,197,94,0.1); color: #15803d; font-size: 0.7rem;">{{ $product->stock }}</span>
                        @else
                            <span class="badge" style="background: rgba(239,68,68,0.1); color: #b91c1c; font-size: 0.7rem;">Habis</span>
                        @endif
                    </td>
                    <td>
                        @if($product->status === 'active')
                            <span class="badge" style="background: rgba(34,197,94,0.1); color: #15803d; font-size: 0.7rem;">Aktif</span>
                        @else
                            <span class="badge" style="background: rgba(239,68,68,0.1); color: #b91c1c; font-size: 0.7rem;">Nonaktif</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-icon btn-sm" style="width: 28px; height: 28px; border-radius: 6px; background: rgba(var(--accent-rgb, 79,110,247), 0.1); color: var(--accent);" title="Edit">
                                <i class="bi bi-pencil-square" style="font-size: 0.75rem;"></i>
                            </a>
                            <button type="button" class="btn btn-icon btn-sm btn-delete-product"
                                    data-id="{{ $product->id }}"
                                    data-name="{{ $product->name }}"
                                    title="Hapus"
                                    style="width: 28px; height: 28px; border-radius: 6px; background: rgba(239,68,68,0.1); color: #ef4444;">
                                <i class="bi bi-trash" style="font-size: 0.75rem;"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center" style="padding: 40px 0;">
                        <div style="color: var(--text-muted);">
                            <i class="bi bi-inbox" style="font-size: 1.5rem; display: block; margin-bottom: 8px;"></i>
                            <span style="font-size: 0.82rem;">Tidak ada produk ditemukan</span>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="pagination-toolbar">
    <x-pagination :paginator="$products" label="produk" :perPage="$perPage" />
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all checkbox
    const selectAll = document.getElementById('select-all-products');
    const checkboxes = document.querySelectorAll('#kt_products_table tbody .form-check-input');

    if (selectAll) {
        selectAll.addEventListener('change', function() {
            checkboxes.forEach(cb => {
                cb.checked = selectAll.checked;
                const row = cb.closest('tr');
                if (selectAll.checked) {
                    row.classList.add('selected');
                } else {
                    row.classList.remove('selected');
                }
            });
            document.dispatchEvent(new CustomEvent('productSelectionChanged'));
        });
    }

    checkboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            const row = this.closest('tr');
            if (this.checked) {
                row.classList.add('selected');
            } else {
                row.classList.remove('selected');
            }
            document.dispatchEvent(new CustomEvent('productSelectionChanged'));
        });
    });

    // Delete single product
    document.querySelectorAll('.btn-delete-product').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            Ravaa.confirm('Hapus Produk?', `Produk "${name}" akan dihapus permanen. Tindakan ini tidak dapat dibatalkan!`, 'error').then(function(result) {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/admin/products/' + id;
                    form.innerHTML = `
                        @csrf
                        @method('DELETE')
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
});
</script>
