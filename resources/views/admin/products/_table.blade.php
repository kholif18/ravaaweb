@php
    $perPage = request('per_page', 15);
    $tab = $tab ?? request('tab', 'publish');
@endphp

<div class="table-responsive">
    <table class="table align-middle mb-0" id="kt_products_table">
        <thead>
            <tr>
                <th style="width: 32px;">
                    <div class="form-check" style="margin: 0;">
                        <input class="form-check-input" type="checkbox" id="select-all">
                    </div>
                </th>
                <th style="min-width: 200px;">Produk</th>
                <th style="min-width: 100px;">Kategori</th>
                @if($tab !== 'trash')
                <th style="min-width: 100px;">Harga</th>
                <th style="width: 60px;">Stok</th>
                @endif
                @if($tab === 'trash')
                <th style="min-width: 140px;">Dihapus</th>
                @endif
                <th style="width: 70px;">Status</th>
                <th style="width: 100px;" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>
                        <div class="form-check" style="margin: 0;">
                            <input class="form-check-input select-item" type="checkbox" value="{{ $product->id }}">
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
                                @if($tab === 'trash')
                                    <span style="color: var(--text-primary); font-size: 0.82rem; font-weight: 500;">
                                        {{ Str::limit($product->name, 40) }}
                                    </span>
                                @else
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="text-hover-primary fw-semibold" style="color: var(--text-primary); text-decoration: none; font-size: 0.82rem;">
                                        {{ Str::limit($product->name, 40) }}
                                    </a>
                                @endif
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
                    @if($tab !== 'trash')
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
                        @if($product->is_service)
                            <span class="badge" style="background: rgba(79,110,247,0.1); color: var(--accent); font-size: 0.7rem;">Layanan</span>
                        @elseif($product->stock > 0)
                            <span class="badge" style="background: rgba(34,197,94,0.1); color: #15803d; font-size: 0.7rem;">Tersedia</span>
                        @else
                            <span class="badge" style="background: rgba(239,68,68,0.1); color: #b91c1c; font-size: 0.7rem;">Habis</span>
                        @endif
                    </td>
                    @endif
                    @if($tab === 'trash')
                    <td style="font-size: 0.78rem; color: var(--text-muted);">
                        {{ $product->deleted_at ? $product->deleted_at->diffForHumans() : '-' }}
                    </td>
                    @endif
                    <td>
                        @if($tab === 'trash')
                            <span class="badge" style="background: rgba(239,68,68,0.1); color: #b91c1c; font-size: 0.7rem;">Sampah</span>
                        @elseif($product->status === 'active')
                            <span class="badge" style="background: rgba(34,197,94,0.1); color: #15803d; font-size: 0.7rem;">Aktif</span>
                        @else
                            <span class="badge" style="background: rgba(239,68,68,0.1); color: #b91c1c; font-size: 0.7rem;">Nonaktif</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                            @if($tab === 'trash')
                                <button type="button" class="btn btn-icon btn-sm btn-restore-product"
                                        data-id="{{ $product->id }}"
                                        data-name="{{ $product->name }}"
                                        title="Pulihkan"
                                        style="width: 28px; height: 28px; border-radius: 6px; background: rgba(34,197,94,0.1); color: #15803d;">
                                    <i class="bi bi-arrow-counterclockwise" style="font-size: 0.75rem;"></i>
                                </button>
                                <button type="button" class="btn btn-icon btn-sm btn-force-delete-product"
                                        data-id="{{ $product->id }}"
                                        data-name="{{ $product->name }}"
                                        title="Hapus Permanen"
                                        style="width: 28px; height: 28px; border-radius: 6px; background: rgba(239,68,68,0.1); color: #ef4444;">
                                    <i class="bi bi-trash3" style="font-size: 0.75rem;"></i>
                                </button>
                            @else
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-icon btn-sm" style="width: 28px; height: 28px; border-radius: 6px; background: rgba(var(--accent-rgb, 79,110,247), 0.1); color: var(--accent);" title="Edit">
                                    <i class="bi bi-pencil-square" style="font-size: 0.75rem;"></i>
                                </a>
                                <button type="button" class="btn btn-icon btn-sm btn-delete-product"
                                        data-id="{{ $product->id }}"
                                        data-name="{{ $product->name }}"
                                        title="Hapus"
                                        style="width: 28px; height: 28px; border-radius: 6px; background: rgba(239,68,68,0.1); color: #ef4444;">
                                    <i class="bi bi-trash" style="font-size: 0.75rem;"></i>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ $tab === 'trash' ? '6' : '7' }}" class="text-center" style="padding: 40px 0;">
                        <div style="color: var(--text-muted);">
                            <i class="bi {{ $tab === 'trash' ? 'bi-trash' : 'bi-inbox' }}" style="font-size: 1.5rem; display: block; margin-bottom: 8px;"></i>
                            <span style="font-size: 0.82rem;">
                                @if($tab === 'trash')
                                    Tidak ada produk di sampah
                                @else
                                    Tidak ada produk ditemukan
                                @endif
                            </span>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination & Bulk Delete -->
<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-3">
    <div>
        @if($tab === 'trash')
            <button type="button" class="btn btn-sm btn-success" id="bulk-restore-btn" style="display: none;">
                <i class="bi bi-arrow-counterclockwise"></i> Pulihkan
            </button>
            <button type="button" class="btn btn-sm btn-danger" id="bulk-force-delete-btn" style="display: none;">
                <i class="bi bi-trash3"></i> Hapus Permanen
            </button>
        @else
            <button type="button" class="btn btn-sm btn-light-danger" id="bulk-delete-btn" style="display: none;">
                <i class="bi bi-trash"></i> Hapus
            </button>
        @endif
    </div>
    <x-pagination :paginator="$products" label="produk" :perPage="$perPage" />
</div>


