@extends('admin.layouts.app')

@section('page-title', 'General Settings')

@section('breadcrumb')
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-dark">General Settings</li>
@endsection

@section('content')
<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
    <div class="col-xl-12">
        <div class="card card-flush h-lg-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Pengaturan Umum</span>
                    <span class="text-gray-400 mt-1 fw-semibold fs-6">Kelola konfigurasi dasar website</span>
                </h3>
            </div>
            
            <div class="card-body">
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-8">
                        @foreach($settings as $setting)
                        <div class="col-md-6 mb-6">
                            <label class="form-label fw-bold fs-6">{{ ucwords(str_replace('_', ' ', $setting->key)) }}</label>
                            
                            @if($setting->type === 'textarea')
                                <textarea name="{{ $setting->key }}" class="form-control form-control-solid" rows="3">{{ $setting->value }}</textarea>
                            @elseif($setting->type === 'image')
                                <div class="mt-1">
                                    <div class="image-input image-input-outline {{ $setting->value ? '' : 'image-input-empty' }}" data-kt-image-input="true" style="background-image: url({{ asset('admin/assets/media/svg/files/blank-image.svg') }})">
                                        <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{ $setting->value ? asset('storage/' . $setting->value) : 'none' }})"></div>
                                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Ubah Gambar">
                                            <i class="bi bi-pencil-fill fs-7"></i>
                                            <input type="file" name="{{ $setting->key }}" accept=".png, .jpg, .jpeg" />
                                            <input type="hidden" name="{{ $setting->key }}_remove" />
                                        </label>
                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Batal">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Hapus">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                    </div>
                                    <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                </div>
                            @else
                                <input type="text" name="{{ $setting->key }}" class="form-control form-control-solid" value="{{ $setting->value }}" />
                            @endif
                        </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="reset" class="btn btn-light me-3">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
