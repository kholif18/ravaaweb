@extends('admin.layouts.app')

@section('page-title', 'Role & Permission')

@section('breadcrumb')
    <li>
        <a href="{{ route('admin.dashboard') }}">
            <i class="bi bi-house-door"></i> Home
        </a>
    </li>
    <li class="bc-separator"><i class="bi bi-chevron-right"></i></li>
    <li>
        <a href="{{ route('admin.roles.index') }}">Role & Permission</a>
    </li>
@endsection

@section('content')
<div class="glass-card">
    <div class="card-header">
        <div class="card-title">Role &amp; Permission</div>
    </div>
    <div class="card-body">

        {{-- Info Banner --}}
        <div class="alert alert-info d-flex align-items-start gap-3" style="background: rgba(0,113,227,0.06); border: 1px solid rgba(0,113,227,0.15); border-radius: 12px; padding: 1rem 1.25rem;">
            <i class="bi bi-info-circle" style="font-size: 1.2rem; color: var(--accent); margin-top: 2px;"></i>
            <div>
                <strong style="color: var(--text-primary);">Satu Role untuk Website Pribadi</strong>
                <p style="margin: 4px 0 0; color: var(--text-muted); font-size: 0.85rem;">
                    Website ini menggunakan sistem role yang disederhanakan. Cukup <strong>1 role (admin)</strong> dengan akses penuh ke seluruh fitur admin.
                    Tidak ada permission granular — semua admin user memiliki kemampuan yang sama.
                </p>
            </div>
        </div>

        {{-- Stats Row --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-3 p-3" style="background: rgba(0,113,227,0.04); border-radius: 12px; border: 1px solid rgba(0,113,227,0.1);">
                    <div class="d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; border-radius: 10px; background: rgba(0,113,227,0.08);">
                        <i class="bi bi-shield-check" style="font-size: 1.2rem; color: var(--accent);"></i>
                    </div>
                    <div>
                        <div style="font-size: 1.4rem; font-weight: 700; color: var(--text-primary);">{{ $roles->count() }}</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted);">Total Role</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-3 p-3" style="background: rgba(34,197,94,0.04); border-radius: 12px; border: 1px solid rgba(34,197,94,0.1);">
                    <div class="d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; border-radius: 10px; background: rgba(34,197,94,0.08);">
                        <i class="bi bi-people" style="font-size: 1.2rem; color: #15803d;"></i>
                    </div>
                    <div>
                        <div style="font-size: 1.4rem; font-weight: 700; color: var(--text-primary);">{{ $totalUsers }}</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted);">Total Pengguna</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-3 p-3" style="background: rgba(245,158,11,0.04); border-radius: 12px; border: 1px solid rgba(245,158,11,0.1);">
                    <div class="d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; border-radius: 10px; background: rgba(245,158,11,0.08);">
                        <i class="bi bi-key" style="font-size: 1.2rem; color: #b45309;"></i>
                    </div>
                    <div>
                        <div style="font-size: 1.4rem; font-weight: 700; color: var(--text-primary);">{{ $allPermissions->count() }}</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted);">Total Permission</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Role Cards --}}
        <h5 style="font-weight: 600; margin-bottom: 1rem; color: var(--text-primary);">Daftar Role</h5>

        @if($roles->count() > 0)
        <div class="row g-3">
            @foreach($roles as $role)
            <div class="col-md-6">
                <div class="p-3" style="background: rgba(0,113,227,0.03); border: 1px solid rgba(0,113,227,0.1); border-radius: 12px;">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center gap-2">
                            <div class="d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; border-radius: 8px; background: rgba(0,113,227,0.08);">
                                <i class="bi bi-shield-fill-check" style="color: var(--accent);"></i>
                            </div>
                            <div>
                                <strong style="color: var(--text-primary); text-transform: capitalize;">{{ $role->name }}</strong>
                                <div style="font-size: 0.75rem; color: var(--text-muted);">Guard: {{ $role->guard_name }}</div>
                            </div>
                        </div>
                        <span class="td-badge badge" style="background: rgba(0,113,227,0.08); color: var(--accent);">
                            {{ $role->users_count }} pengguna
                        </span>
                    </div>
                    <div style="font-size: 0.82rem; color: var(--text-muted);">
                        <i class="bi bi-people"></i> Pengguna dengan role ini:
                        @php
                            $roleUsers = $role->users()->take(5)->get();
                        @endphp
                        @if($roleUsers->count() > 0)
                            @foreach($roleUsers as $u)
                            <span class="td-badge badge" style="background: rgba(0,113,227,0.06); color: var(--text-primary); font-size: 0.75rem; margin-right: 4px;">
                                {{ $u->name }}
                            </span>
                            @endforeach
                            @if($role->users_count > 5)
                            <span style="color: var(--text-muted); font-size: 0.75rem;">+{{ $role->users_count - 5 }} lainnya</span>
                            @endif
                        @else
                            <em style="color: var(--text-muted);">Tidak ada pengguna</em>
                        @endif
                    </div>

                    {{-- Permissions --}}
                    @if($role->permissions->count() > 0)
                    <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid rgba(0,0,0,0.05);">
                        <div style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 6px;"><i class="bi bi-key"></i> Permission:</div>
                        <div class="d-flex flex-wrap gap-1">
                            @foreach($role->permissions as $perm)
                            <span class="td-badge badge" style="background: rgba(34,197,94,0.08); color: #15803d; font-size: 0.72rem;">
                                {{ $perm->name }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @else
                    <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid rgba(0,0,0,0.05);">
                        <div style="font-size: 0.75rem; color: var(--text-muted);">
                            <i class="bi bi-key"></i> Tidak ada permission spesifik — akses penuh via middleware <code>role:admin,admin</code>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-state">
            <i class="bi bi-shield-exclamation" style="font-size: 2.5rem; color: var(--text-muted);"></i>
            <p style="color: var(--text-muted); margin-top: 0.5rem;">Belum ada role dengan guard admin.</p>
        </div>
        @endif

        {{-- Module Access Table --}}
        <h5 style="font-weight: 600; margin: 2rem 0 1rem; color: var(--text-primary);">Akses Module per Role</h5>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Module</th>
                        @foreach($roles as $role)
                        <th class="text-center" style="text-transform: capitalize;">{{ $role->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @php
                        $modules = [
                            'Dashboard' => 'admin.dashboard',
                            'Kategori' => 'admin.categories.*',
                            'Tag' => 'admin.tags.*',
                            'Media' => 'admin.media.*',
                            'Produk' => 'admin.products.*',
                            'Layanan' => 'admin.services.*',
                            'Portfolio' => 'admin.portfolio.*',
                            'Testimoni' => 'admin.testimonials.*',
                            'Banner' => 'admin.banners.*',
                            'Home Builder' => 'admin.home.*',
                            'Pengaturan' => 'admin.settings.*',
                            'Pengguna' => 'admin.users.*',
                            'Role & Permission' => 'admin.roles.*',
                        ];
                    @endphp
                    @foreach($modules as $moduleName => $routePattern)
                    <tr>
                        <td><span style="font-weight: 500; color: var(--text-primary);">{{ $moduleName }}</span></td>
                        @foreach($roles as $role)
                        <td class="text-center">
                            <i class="bi bi-check-circle-fill" style="color: #15803d; font-size: 1.1rem;"></i>
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <p style="color: var(--text-muted); font-size: 0.8rem; margin-top: 0.5rem;">
            <i class="bi bi-info-circle"></i> Semua role memiliki akses penuh ke semua module karena middleware menggunakan <code>role:admin,admin</code>.
        </p>

    </div>
</div>
@endsection
