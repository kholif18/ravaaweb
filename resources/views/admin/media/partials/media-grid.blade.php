@if($media->count() > 0)
    <div class="row g-6">
        @foreach($media as $item)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="media-card"
                     data-id="{{ $item->id }}"
                     data-url="{{ $item->url }}"
                     data-thumbnail="{{ $item->thumbnail_url ?? $item->url }}"
                     data-name="{{ $item->name }}">
                    
                    <div class="card-img position-relative">
                        <img src="{{ $item->thumbnail_url ?? $item->url }}" 
                             alt="{{ $item->name }}"
                             class="img-fluid"
                             loading="lazy">
                        
                        <div class="media-check">
                            <i class="bi bi-check"></i>
                        </div>
                        
                        <div class="media-overlay">
                            <button type="button" class="btn btn-primary btn-select-media"
                                    data-media-id="{{ $item->id }}">
                                <i class="bi bi-check-lg me-1"></i> Pilih
                            </button>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <h6 class="card-title">{{ Str::limit($item->name, 20) }}</h6>
                        <p class="card-text">
                            {{ strtoupper($item->extension) }} 
                            @if($item->formatted_size)
                                • {{ $item->formatted_size }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    @if($media->hasPages())
        <div class="row mt-8">
            <div class="col-12">
                <nav aria-label="Media pagination">
                    <ul class="pagination pagination-outline justify-content-center">
                        {{-- Previous Page Link --}}
                        @if ($media->onFirstPage())
                            <li class="page-item disabled"><span class="page-link"><i class="bi bi-chevron-left"></i></span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="loadMediaLibrary({{ $media->currentPage() - 1 }})"><i class="bi bi-chevron-left"></i></a></li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($media->getUrlRange(max(1, $media->currentPage() - 2), min($media->lastPage(), $media->currentPage() + 2)) as $page => $url)
                            <li class="page-item {{ $page == $media->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="javascript:void(0)" onclick="loadMediaLibrary({{ $page }})">{{ $page }}</a>
                            </li>
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($media->hasMorePages())
                            <li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="loadMediaLibrary({{ $media->currentPage() + 1 }})"><i class="bi bi-chevron-right"></i></a></li>
                        @else
                            <li class="page-item disabled"><span class="page-link"><i class="bi bi-chevron-right"></i></span></li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    @endif
@else
    <div class="col-12 text-center py-10">
        <i class="bi bi-image text-muted" style="font-size: 48px;"></i>
        <h5 class="text-muted mt-3">Tidak ada media ditemukan</h5>
        <p class="text-muted">
            @if(request('search'))
                Tidak ada hasil untuk "{{ request('search') }}"
            @else
                Upload file baru menggunakan tab upload
            @endif
        </p>
    </div>
@endif