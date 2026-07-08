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

@stack('scripts')
