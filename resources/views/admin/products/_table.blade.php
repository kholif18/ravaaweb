@php
    $perPage = request('per_page', 15);
@endphp

<div class="table-responsive">
    <table class="table align-middle table-row-dashed fs-6" id="kt_products_table">
        <thead>
            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase">
                <th class="w-25px pe-2">
                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                        <input class="form-check-input" type="checkbox" id="select-all-products">
                    </div>
                </th>
                <th class="min-w-150px">Produk</th>
                <th class="min-w-120px">Kategori</th>
                <th class="min-w-80px">Harga</th>
                <th class="min-w-80px">Stok</th>
                <th class="min-w-80px">Status</th>
                <th class="min-w-80px text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 fw-semibold">
            @forelse($products as $product)
                <tr>
                    <td>
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" value="{{ $product->id }}">
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            @if($product->thumbnail)
                                <img src="{{ $product->thumbnail->url }}" alt="{{ $product->name }}" class="product-thumb">
                            @else
                                <div class="product-thumb-placeholder"><i class="bi bi-image"></i></div>
                            @endif
                            <div>
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-gray-800 text-hover-primary fw-bold">
                                    {{ $product->name }}
                                </a>
                                @if($product->sku)
                                    <div class="text-muted fs-8">SKU: {{ $product->sku }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-light-primary">{{ $product->category->name ?? '-' }}</span>
                    </td>
                    <td>
                        @if($product->price_discount)
                            <span class="text-muted text-decoration-line-through fs-8">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <br>
                            <span class="text-danger fw-bold">Rp {{ number_format($product->price_discount, 0, ',', '.') }}</span>
                        @else
                            <span class="fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        @endif
                    </td>
                    <td>
                        @if($product->stock > 0)
                            <span class="badge badge-light-success">{{ $product->stock }}</span>
                        @else
                            <span class="badge badge-light-danger">Habis</span>
                        @endif
                    </td>
                    <td>
                        @if($product->status === 'active')
                            <span class="badge badge-light-success">Aktif</span>
                        @else
                            <span class="badge badge-light-danger">Nonaktif</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-icon btn-light-primary btn-sm" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button type="button" class="btn btn-icon btn-light-danger btn-sm btn-delete-product"
                                    data-id="{{ $product->id }}"
                                    data-name="{{ $product->name }}"
                                    title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-10">
                        <div class="text-gray-500">
                            <i class="bi bi-inbox fs-2x mb-3 d-block"></i>
                            Tidak ada produk ditemukan
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
            // Trigger bulk UI update via custom event
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
