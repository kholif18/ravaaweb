@extends('admin.layouts.app')

@section('page-title', 'Pengguna Admin')

@section('breadcrumb')
    <li>
        <a href="{{ route('admin.dashboard') }}">
            <i class="bi bi-house-door"></i> Home
        </a>
    </li>
    <li class="bc-separator"><i class="bi bi-chevron-right"></i></li>
    <li>
        <a href="{{ route('admin.users.index') }}">Pengguna Admin</a>
    </li>
@endsection

@section('content')
<!-- Toast Container -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
    <div id="toastContainer"></div>
</div>

<!--begin::Card-->
<div class="glass-card">
    <!--begin::Card header-->
    <div class="card-header">
        <div class="card-title">Daftar Pengguna Admin</div>
        <div class="card-header-btns">
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
                <i class="bi bi-plus-circle"></i> Tambah
            </button>
        </div>
    </div>
    <!--end::Card header-->

    <div class="card-body">
        <!-- Table toolbar -->
        <div class="table-toolbar">
            <div class="toolbar-group">
                <div class="d-flex align-items-center gap-2">
                    <div class="input-group input-group-sm" style="max-width: 200px;">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control"
                               data-kt-user-table-filter="search"
                               placeholder="Cari Pengguna..."
                               name="search"
                               value="{{ $filters['search'] ?? '' }}">
                    </div>
                    <select name="status" class="form-select form-select-sm" style="min-width: 110px;">
                        <option value="">Semua Status</option>
                        <option value="active" {{ ($filters['status'] ?? '') === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ ($filters['status'] ?? '') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Table container for AJAX refresh -->
        <div id="users-table-container">
            @include('admin.users._table')
        </div>
    </div>
</div>

<!-- ===== MODAL ADD ===== -->
<div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-500px">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h3 class="fw-bold">Tambah Pengguna</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </div>
            </div>

            <form id="kt_modal_add_user_form" class="form" action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-body py-4 px-4">
                    <div class="fv-row mb-3">
                        <label class="required fs-7 fw-semibold mb-1">Nama Lengkap</label>
                        <input type="text" class="form-control form-control-sm"
                               placeholder="Masukkan nama lengkap"
                               name="name" required />
                        <div class="text-danger fs-8 mt-1" id="add_name_error"></div>
                    </div>

                    <div class="fv-row mb-3">
                        <label class="required fs-7 fw-semibold mb-1">Email</label>
                        <input type="email" class="form-control form-control-sm"
                               placeholder="Masukkan alamat email"
                               name="email" required />
                        <div class="text-danger fs-8 mt-1" id="add_email_error"></div>
                    </div>

                    <div class="fv-row mb-3">
                        <label class="required fs-7 fw-semibold mb-1">Password</label>
                        <input type="password" class="form-control form-control-sm"
                               placeholder="Minimal 8 karakter"
                               name="password" required minlength="8" />
                        <div class="text-danger fs-8 mt-1" id="add_password_error"></div>
                    </div>

                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-1">Role</label>
                        <select class="form-select form-select-sm" name="role">
                            @foreach($allRoles as $role)
                            <option value="{{ $role->name }}" {{ $role->name === 'admin' ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="fv-row mb-0">
                        <label class="fs-7 fw-semibold mb-1">Status</label>
                        <div class="form-check form-switch" style="margin-top: 4px;">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" checked
                                   id="add_user_active" style="cursor: pointer; width: 40px; height: 20px;">
                            <label class="form-check-label fs-7" for="add_user_active" style="cursor: pointer;">Aktif</label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer py-3 px-4">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="kt_modal_add_user_submit">
                        <span class="indicator-label">Simpan</span>
                        <span class="indicator-progress" style="display: none;">
                            <span class="spinner-border spinner-border-sm align-middle"></span> Menyimpan...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ===== MODAL EDIT ===== -->
<div class="modal fade" id="kt_modal_edit_user" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-500px">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h3 class="fw-bold">Edit Pengguna</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </div>
            </div>

            <form id="kt_modal_edit_user_form" class="form" method="POST"
                  data-update-url="{{ route('admin.users.update', ':id') }}">
                @csrf
                @method('PUT')
                <div class="modal-body py-4 px-4">
                    <div class="fv-row mb-3">
                        <label class="required fs-7 fw-semibold mb-1">Nama Lengkap</label>
                        <input type="text" class="form-control form-control-sm"
                               placeholder="Masukkan nama lengkap"
                               name="name" id="edit_name" required />
                        <div class="text-danger fs-8 mt-1" id="edit_name_error"></div>
                    </div>

                    <div class="fv-row mb-3">
                        <label class="required fs-7 fw-semibold mb-1">Email</label>
                        <input type="email" class="form-control form-control-sm"
                               placeholder="Masukkan alamat email"
                               name="email" id="edit_email" required />
                        <div class="text-danger fs-8 mt-1" id="edit_email_error"></div>
                    </div>

                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-1">Password <span style="color: var(--text-muted); font-weight: 400;">(kosongkan jika tidak diubah)</span></label>
                        <input type="password" class="form-control form-control-sm"
                               placeholder="Minimal 8 karakter"
                               name="password" minlength="8" />
                        <div class="text-danger fs-8 mt-1" id="edit_password_error"></div>
                    </div>

                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-1">Role</label>
                        <select class="form-select form-select-sm" name="role" id="edit_role">
                            @foreach($allRoles as $role)
                            <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="fv-row mb-0">
                        <label class="fs-7 fw-semibold mb-1">Status</label>
                        <div class="form-check form-switch" style="margin-top: 4px;">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                   id="edit_user_active" style="cursor: pointer; width: 40px; height: 20px;">
                            <label class="form-check-label fs-7" for="edit_user_active" style="cursor: pointer;">Aktif</label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer py-3 px-4">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="kt_modal_edit_user_submit">
                        <span class="indicator-label">Simpan</span>
                        <span class="indicator-progress" style="display: none;">
                            <span class="spinner-border spinner-border-sm align-middle"></span> Menyimpan...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ===== DELETE FORM ===== -->
<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
// --- Show flash messages via Ravaa toast ---
// Wait for DOMContentLoaded because app.js defines Ravaa.* inside that event.
document.addEventListener('DOMContentLoaded', function () {
    @if(session('success'))
        Ravaa.toast('{{ session('success') }}', 'success');
    @endif
    @if(session('error'))
        Ravaa.toast('{{ session('error') }}', 'error');
    @endif
    @if($errors->any())
        Ravaa.toast('{{ $errors->first() }}', 'error');
    @endif
});

// --- Live Search + Filter ---
let filterTimer;
document.querySelectorAll('[data-kt-user-table-filter="search"]').forEach(el => {
    el.addEventListener('input', function() {
        clearTimeout(filterTimer);
        filterTimer = setTimeout(() => applyFilters(), 400);
    });
});
document.querySelectorAll('select[name="status"]').forEach(el => {
    el.addEventListener('change', applyFilters);
});

function applyFilters() {
    const search = document.querySelector('[data-kt-user-table-filter="search"]')?.value || '';
    const status = document.querySelector('select[name="status"]')?.value || '';

    const params = new URLSearchParams({ search, status });

    fetch(`{{ route('admin.users.index') }}?${params.toString()}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' }
    })
    .then(r => r.text())
    .then(html => {
        document.getElementById('users-table-container').innerHTML = html;
        bindSelectAll();
    })
    .catch(() => {});
}

function bindSelectAll() {
    const selectAll = document.getElementById('select-all');
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            document.querySelectorAll('.select-item').forEach(cb => cb.checked = this.checked);
        });
    }
}
bindSelectAll();

// --- Edit User ---
let usersData = @json($users->items());

window.editUser = function(id) {
    const user = usersData.find(u => u.id === id);
    if (!user) return;

    const form = document.getElementById('kt_modal_edit_user_form');
    form.action = form.dataset.updateUrl.replace(':id', id);

    document.getElementById('edit_name').value = user.name;
    document.getElementById('edit_email').value = user.email;
    document.getElementById('edit_user_active').checked = user.is_active;

    // Set role
    const roleSelect = document.getElementById('edit_role');
    if (roleSelect && user.roles && user.roles.length > 0) {
        roleSelect.value = user.roles[0].name;
    }

    // Clear errors
    document.querySelectorAll('#kt_modal_edit_user_form .text-danger').forEach(el => el.textContent = '');
    document.getElementById('edit_password').value = '';
};

// --- Confirm Delete via Ravaa ---
window.confirmDelete = function(id, name) {
    const url = `{{ route('admin.users.index') }}/${id}`;
    Ravaa.confirm('Hapus Pengguna', `Yakin ingin menghapus "${name}"? Tindakan ini tidak dapat dibatalkan.`, 'error')
        .then(function(result) {
            if (result) {
                const form = document.getElementById('delete-form');
                form.action = url;
                form.submit();
            }
        });
};

// --- Loading state on submit ---
document.querySelectorAll('.modal form').forEach(form => {
    form.addEventListener('submit', function() {
        const btn = this.querySelector('button[type="submit"]');
        if (btn) {
            btn.disabled = true;
            btn.querySelector('.indicator-label')?.style.setProperty('display', 'none');
            btn.querySelector('.indicator-progress')?.style.setProperty('display', 'inline-flex');
        }
    });
});
</script>
@endpush
