{{-- jQuery --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

{{-- Bootstrap 5 JS (for modal compat) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- ApexCharts (for dashboard charts) --}}
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.44.2/dist/apexcharts.min.js"></script>

{{-- SortableJS (drag-and-drop reordering) --}}
<script src="{{ asset('admin/vendor/sortablejs/Sortable.min.js') }}"></script>

{{-- Admin Core JS --}}
<script src="{{ asset('admin/js/app.js') }}"></script>

@include('admin.partials.ravaa-js')

{{-- Fix: Prevent modal close on drag-from-content-to-backdrop --}}
<script>
document.addEventListener('mousedown', function(e) {
    const modalContent = e.target.closest('.modal-content');
    if (modalContent) {
        modalContent._mouseDownInside = true;
    }
});
document.addEventListener('mouseup', function(e) {
    document.querySelectorAll('.modal-content').forEach(function(el) {
        el._mouseDownInside = false;
    });
});
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal') && e.target._mouseDownInside) {
        e.stopPropagation();
        e.target._mouseDownInside = false;
    }
}, true);
</script>

@stack('scripts')
