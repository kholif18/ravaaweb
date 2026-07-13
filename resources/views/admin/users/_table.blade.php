@if($users->count() > 0)
<div class="table-responsive">
<table class="table" id="kt_users_table">
    <thead>
        <tr>
            <th style="width: 32px;">
                <div class="form-check" style="margin: 0;">
                    <input class="form-check-input" type="checkbox" id="select-all" />
                </div>
            </th>
            <th>Nama</th>
            <th>Email</th>
            <th style="width: 100px;">Role</th>
            <th style="width: 100px;">Status</th>
            <th style="width: 150px;">Terdaftar</th>
            <th style="width: 120px;" class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr data-id="{{ $user->id }}">
            <td>
                <div class="form-check" style="margin: 0;">
                    <input class="form-check-input select-item" type="checkbox" value="{{ $user->id }}" />
                </div>
            </td>
            <td>
                <div class="d-flex align-items-center gap-2">
                    <div class="td-symbol d-flex align-items-center justify-content-center"
                         style="background: rgba(var(--accent-rgb, 0,113,227),0.08); width: 32px; height: 32px; border-radius: 8px;">
                        <i class="bi bi-person-fill" style="font-size: 0.9rem; color: var(--accent);"></i>
                    </div>
                    <div>
                        <a href="#" class="fw-semibold text-hover-primary" style="color: var(--text-primary); text-decoration: none;"
                            onclick="editUser({{ $user->id }})"
                            data-bs-toggle="modal" data-bs-target="#kt_modal_edit_user">
                            {{ $user->name }}
                        </a>
                    </div>
                </div>
            </td>
            <td>
                <span style="color: var(--text-muted); font-size: 0.85rem;">{{ $user->email }}</span>
            </td>
            <td>
                @php $userRole = $user->roles->first() @endphp
                @if($userRole)
                <span class="td-badge badge" style="background: rgba(0,113,227,0.1); color: #0071e3;">{{ $userRole->name }}</span>
                @else
                <span class="td-badge badge" style="background: rgba(239,68,68,0.1); color: #b91c1c;">None</span>
                @endif
            </td>
            <td>
                @if($user->is_active)
                <span class="td-badge badge badge-success" style="background: rgba(34,197,94,0.1); color: #15803d;">Aktif</span>
                @else
                <span class="td-badge badge badge-danger" style="background: rgba(239,68,68,0.1); color: #b91c1c;">Nonaktif</span>
                @endif
            </td>
            <td>
                <span style="color: var(--text-muted); font-size: 0.82rem;">{{ $user->created_at->format('d M Y H:i') }}</span>
            </td>
            <td class="text-center">
                <div class="d-flex justify-content-center gap-1">
                    <button type="button" class="btn btn-sm btn-light-primary" 
                            onclick="editUser({{ $user->id }})"
                            data-bs-toggle="modal" data-bs-target="#kt_modal_edit_user"
                            title="Edit">
                        <i class="bi bi-pencil"></i>
                    </button>
                    @if((int) auth()->guard('admin')->id() !== (int) $user->id)
                    <form method="POST" action="{{ route('admin.users.update-status', $user) }}" class="d-inline">
                        @csrf
                        @method('PUT')
                        @if($user->is_active)
                        <button type="submit" name="is_active" value="0" class="btn btn-sm btn-light-warning" title="Nonaktifkan">
                            <i class="bi bi-pause-circle"></i>
                        </button>
                        @else
                        <button type="submit" name="is_active" value="1" class="btn btn-sm btn-light-success" title="Aktifkan">
                            <i class="bi bi-play-circle"></i>
                        </button>
                        @endif
                    </form>
                    <button type="button" class="btn btn-sm btn-light-danger" 
                            onclick="confirmDelete({{ $user->id }}, '{{ addslashes($user->name) }}')"
                            title="Hapus">
                        <i class="bi bi-trash"></i>
                    </button>
                    @endif
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>

{{ $users->links() }}
@else
<div class="empty-state">
    <i class="bi bi-people" style="font-size: 2.5rem; color: var(--text-muted);"></i>
    <p style="color: var(--text-muted); margin-top: 0.5rem;">Belum ada pengguna.</p>
</div>
@endif
