@props([
    'paginator',
    'perPage' => 10,
    'label' => 'item',
    'info' => true,
])

<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-2">
    <div class="d-flex align-items-center gap-2">
        @if($info)
        <div class="fs-8 fw-semibold text-gray-700 text-nowrap">
            @if($paginator->total() > 0)
                {{ $paginator->firstItem() }} - {{ $paginator->lastItem() }} dari {{ $paginator->total() }} {{ $label }}
            @else
                0 dari 0 {{ $label }}
            @endif
        </div>
        @endif

        <div class="d-flex align-items-center gap-1">
            <select
                name="per_page"
                class="form-select form-select-sm form-select-solid pagination-per-page"
                style="width: 68px;"
                data-current-url="{{ url()->current() }}"
                data-query-string="{{ http_build_query(request()->query()) }}"
            >
                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
            </select>
        </div>
    </div>

    <div class="d-flex align-items-center gap-1">
        @isset($slot)
            {{ $slot }}
        @endisset

        @if($paginator->hasPages())
            {{ $paginator->links('vendor.pagination.custom') }}
        @endif
    </div>
</div>

<script>
document.querySelectorAll('.pagination-per-page').forEach(function(select) {
    select.addEventListener('change', function() {
        var baseUrl = this.getAttribute('data-current-url');
        var params = new URLSearchParams(this.getAttribute('data-query-string'));

        params.set('per_page', this.value);
        params.delete('page');

        window.location.href = baseUrl + '?' + params.toString();
    });
});
</script>
