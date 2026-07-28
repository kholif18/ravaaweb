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
                @if($user->locked_until && $user->locked_until->isFuture())
                <span class="td-badge badge" style="background: rgba(239,68,68,0.1); color: #b91c1c;" title="Terkunci hingga {{ $user->locked_until->format('d M H:i') }}">
                    <i class="bi bi-lock-fill" style="font-size: 0.7rem;"></i> Terkunci
                </span>
                @elseif($user->is_active)
                <span class="td-badge badge badge-success" style="background: rgba(34,197,94,0.1); color: #15803d;">Aktif</span>
                @else
                <span class="td-badge badge badge-danger" style="background: rgba(239,68,68,0.1); color: #b91c1c;">Nonaktif</span>
                @endif
            </td>
            <td>
                <span style="color: var(--text-muted); font-size: 0.82rem;">{{ $user->created_at->format('d M Y H:i') }}</span>
            </td>
            <td class="text-center" style="white-space:nowrap;">
                <div class="d-flex justify-content-center gap-1">
                    <button type="button" class="btn btn-icon btn-sm"
                            onclick="editUser({{ $user->id }})"
                            data-bs-toggle="modal" data-bs-target="#kt_modal_edit_user"
                            title="Edit"
                            style="width:28px;height:28px;border-radius:6px;background:rgba(var(--accent-rgb,79,110,247),0.1);color:var(--accent);">
                        <i class="bi bi-pencil-square" style="font-size:0.75rem;"></i>
                    </button>
                    @if($user->locked_until && $user->locked_until->isFuture())
                    <form method="POST" action="{{ route('admin.users.unlock', $user) }}" class="d-inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-icon btn-sm" title="Buka Kunci"
                                style="width:28px;height:28px;border-radius:6px;background:rgba(34,197,94,0.1);color:#15803d;">
                            <i class="bi bi-unlock-fill" style="font-size:0.75rem;"></i>
                        </button>
                    </form>
                    @endif
                    @if((int) auth()->guard('admin')->id() !== (int) $user->id)
                    <form method="POST" action="{{ route('admin.users.update-status', $user) }}" class="d-inline">
                        @csrf
                        @method('PUT')
                        @if($user->is_active)
                        <button type="submit" name="is_active" value="0" class="btn btn-icon btn-sm" title="Nonaktifkan"
                                style="width:28px;height:28px;border-radius:6px;background:rgba(234,179,8,0.1);color:#a16207;">
                            <i class="bi bi-pause-circle" style="font-size:0.75rem;"></i>
                        </button>
                        @else
                        <button type="submit" name="is_active" value="1" class="btn btn-icon btn-sm" title="Aktifkan"
                                style="width:28px;height:28px;border-radius:6px;background:rgba(34,197,94,0.1);color:#15803d;">
                            <i class="bi bi-play-circle" style="font-size:0.75rem;"></i>
                        </button>
                        @endif
                    </form>
                    <button type="button" class="btn btn-icon btn-sm"
                            onclick="confirmDelete({{ $user->id }}, '{{ addslashes($user->name) }}')"
                            title="Hapus"
                            style="width:28px;height:28px;border-radius:6px;background:rgba(239,68,68,0.1);color:#ef4444;">
                        <i class="bi bi-trash" style="font-size:0.75rem;"></i>
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
