@props([
    'paginator',
    'perPage' => 10,
    'label' => 'item',
    'info' => true,
    'perPageAction' => null,
])

<div class="d-flex flex-stack flex-wrap pt-10">
    <div class="d-flex align-items-center gap-5">
        @if($info)
        <div class="fs-6 fw-semibold text-gray-700 text-nowrap">
            @if($paginator->total() > 0)
                {{ $paginator->firstItem() }} - {{ $paginator->lastItem() }} dari {{ $paginator->total() }} {{ $label }}
            @else
                0 dari 0 {{ $label }}
            @endif
        </div>
        @endif

        <div class="d-flex align-items-center gap-2">
            <label class="fs-7 fw-semibold text-gray-700 text-nowrap">Baris per halaman:</label>
            <select name="per_page" class="form-select form-select-sm form-select-solid w-90px">
                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
            </select>
        </div>
    </div>

    <div class="d-flex align-items-center gap-3">
        @isset($slot)
            {{ $slot }}
        @endisset

        @if($paginator->hasPages())
            {{ $paginator->links('vendor.pagination.custom') }}
        @endif
    </div>
</div>
