@if($media->count())
<div class="row g-3" id="mediaLibraryGrid">
    @foreach($media as $item)
    <div class="col-xxl-2 col-xl-3 col-lg-4 col-md-6 col-sm-6 col-6">
        <div class="media-item"
             data-id="{{ $item->id }}"
             data-url="{{ $item->url }}"
             data-thumbnail="{{ $item->thumbnail_url ?? $item->url }}"
             data-name="{{ $item->name }}">

            <div class="media-card-img">
                <img src="{{ $item->thumbnail_url ?? $item->url }}" 
                     class="fixed-thumbnail"
                     alt="{{ $item->name }}"
                     loading="lazy">
            </div>

            <div class="media-info">
                <div class="media-name" title="{{ $item->name }}">
                    {{ Str::limit($item->name, 20) }}
                </div>
                <div class="media-meta">
                    {{ strtoupper($item->extension) }} • {{ $item->formatted_size }}
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-4">
    {{ $media->links('pagination::bootstrap-5') }}
</div>
@else
<div class="text-center py-5 text-muted">
    <i class="bi bi-image" style="font-size: 48px;"></i>
    <p class="mt-3">No media found</p>
</div>
@endif