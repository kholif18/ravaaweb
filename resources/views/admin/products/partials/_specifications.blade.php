{{-- resources/views/admin/products/partials/_specifications.blade.php --}}
<div class="card mb-5">
    <div class="card-header">
        <h4 class="card-title">Deskripsi Lengkap</h4>
    </div>
    <div class="card-body">
        <div class="mb-0">
            <label class="form-label required">Deskripsi Produk</label>
            <textarea name="description" id="description_editor">{{ old('description', $product->description ?? '') }}</textarea>
            @error('description')
                <div class="text-danger fs-7 mt-1">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="card mb-5">
    <div class="card-header">
        <h4 class="card-title">Spesifikasi & Fitur</h4>
    </div>
    <div class="card-body">
        <div class="mb-5">
            <label class="form-label">Spesifikasi Teknis (HTML)</label>
            <textarea name="specifications" id="specifications_editor">{{ old('specifications', $product->specifications ?? '') }}</textarea>
        </div>
    </div>
</div>

<div class="card mb-5">
    <div class="card-header">
        <h4 class="card-title">Informasi Tambahan (Quick Info)</h4>
        <div class="card-toolbar">
            <button type="button" class="btn btn-light-primary btn-sm" id="add-quick-info">
                <i class="bi bi-plus"></i> Tambah Info
            </button>
        </div>
    </div>
    <div class="card-body">
        <div id="quick-infos-container">
            @php
                $quickInfos = old('quick_infos', $product->quick_infos ?? []);
                if (empty($quickInfos)) {
                    $quickInfos = ['Gratis Konsultasi', 'Pengerjaan 3-7 hari', 'Revisi tanpa batas'];
                }
            @endphp
            
            @foreach($quickInfos as $info)
            <div class="input-group mb-2">
                <span class="input-group-text"><i class="bi bi-info-circle"></i></span>
                <input type="text" class="form-control" name="quick_infos[]" value="{{ $info }}" placeholder="Masukkan info singkat..." />
                <button type="button" class="btn btn-light-danger remove-quick-info">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
            @endforeach
        </div>
        <div class="text-muted fs-7 mt-2">Info singkat ini akan muncul sebagai poin-poin fitur utama di halaman detail produk.</div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#add-quick-info').on('click', function() {
            const html = `
                <div class="input-group mb-2">
                    <span class="input-group-text"><i class="bi bi-info-circle"></i></span>
                    <input type="text" class="form-control" name="quick_infos[]" placeholder="Masukkan info singkat..." />
                    <button type="button" class="btn btn-light-danger remove-quick-info">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>`;
            $('#quick-infos-container').append(html);
        });

        $(document).on('click', '.remove-quick-info', function() {
            if ($('#quick-infos-container .input-group').length > 1) {
                $(this).closest('.input-group').remove();
            } else {
                $(this).closest('.input-group').find('input').val('');
            }
        });
    });
</script>
@endpush
