<div>
    <!-- Toolbar/Filters -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text bg-transparent border-end-0">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" 
                       class="form-control border-start-0" 
                       placeholder="Cari media..." 
                       id="searchInput"
                       value="{{ request('search', '') }}"
                       onkeyup="searchMedia()">
            </div>
        </div>
        <div class="col-md-6 text-end">
            <div class="btn-group">
                <button class="btn btn-outline-primary" onclick="refreshMediaList()">
                    <i class="bi bi-arrow-clockwise"></i>
                </button>
                <button class="btn btn-outline-success" onclick="selectAllMedia()" id="selectAllBtn">
                    <i class="bi bi-check-square me-1"></i> Pilih Semua
                </button>
            </div>
        </div>
    </div>
    
    <!-- Media Grid dengan fixed height -->
    @if(count($media) > 0)
        <div class="media-grid" id="mediaGrid">
            @foreach($media as $item)
            <div class="media-item" 
                 data-id="{{ $item->id }}"
                 data-url="{{ $item->url }}"
                 data-thumbnail="{{ $item->thumbnail_url ?? $item->url }}"
                 data-name="{{ $item->name }}"
                 data-search="{{ strtolower($item->name) }} {{ strtolower($item->extension) }}">
                
                <div class="card card-bordered h-100 position-relative">
                    <div class="card-body p-2">
                        <!-- Thumbnail dengan fixed height -->
                        <div class="position-relative mb-2">
                            <img src="{{ $item->thumbnail_url ?? $item->url }}"
                                 class="fixed-thumbnail"
                                 alt="{{ $item->name }}"
                                 loading="lazy"
                                 onerror="this.src='{{ asset('admin/assets/media/svg/files/blank-image.svg') }}'">
                            
                            <!-- Extension badge -->
                            <span class="position-absolute bottom-0 end-0 m-1 badge bg-dark" style="font-size: 10px;">
                                {{ strtoupper($item->extension) }}
                            </span>
                        </div>
                        
                        <!-- File info -->
                        <div class="media-info">
                            <div class="mb-1">
                                <small class="text-dark fw-semibold text-truncate d-block" 
                                       title="{{ $item->name }}" 
                                       data-bs-toggle="tooltip" 
                                       data-bs-placement="top">
                                    {{ Str::limit($item->name, 20) }}
                                </small>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="bi bi-file-earmark-text me-1"></i>
                                    {{ $item->formatted_size }}
                                </small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Select button -->
                    <div class="card-footer bg-transparent border-top-0 pt-0">
                        <button class="btn btn-primary btn-sm w-100 btn-select-media"
                                data-media-id="{{ $item->id }}"
                                data-media-url="{{ $item->url }}"
                                data-media-thumbnail="{{ $item->thumbnail_url ?? $item->url }}"
                                data-media-name="{{ $item->name }}">
                            <i class="bi bi-check-circle me-1"></i> Pilih
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="bi bi-images text-muted" style="font-size: 64px;"></i>
            </div>
            <h5 class="text-muted mb-3">Belum ada media</h5>
            <p class="text-muted mb-4">Upload file pertama Anda untuk memulai</p>
        </div>
    @endif
    
    <!-- Pagination AJAX -->
    @if($media->hasPages())
    <div class="d-flex justify-content-center mt-4">
        <nav aria-label="Media Pagination">
            <ul class="pagination pagination-sm">
                {{-- Previous Page Link --}}
                @if ($media->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">&laquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" 
                           onclick="window.parent.loadPage({{ $media->currentPage() - 1 }})" 
                           aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @php
                    $current = $media->currentPage();
                    $last = $media->lastPage();
                    $start = max($current - 2, 1);
                    $end = min($current + 2, $last);
                @endphp

                @if ($start > 1)
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" onclick="window.parent.loadPage(1)">1</a>
                    </li>
                    @if ($start > 2)
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    @endif
                @endif

                @for ($page = $start; $page <= $end; $page++)
                    @if ($page == $current)
                        <li class="page-item active" aria-current="page">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" onclick="window.parent.loadPage({{ $page }})">
                                {{ $page }}
                            </a>
                        </li>
                    @endif
                @endfor

                @if ($end < $last)
                    @if ($end < $last - 1)
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    @endif
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" onclick="window.parent.loadPage({{ $last }})">
                            {{ $last }}
                        </a>
                    </li>
                @endif

                {{-- Next Page Link --}}
                @if ($media->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" 
                           onclick="window.parent.loadPage({{ $media->currentPage() + 1 }})" 
                           aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">&raquo;</span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
    @endif
</div>