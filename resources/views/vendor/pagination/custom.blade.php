@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item previous disabled">
                <a class="page-link" href="#" aria-label="Previous">
                    <i class="previous"></i>
                </a>
            </li>
        @else
            <li class="page-item previous">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
                    <i class="previous"></i>
                </a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><a class="page-link" href="#">{{ $page }}</a></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item next">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                    <i class="next"></i>
                </a>
            </li>
        @else
            <li class="page-item next disabled">
                <a class="page-link" href="#" aria-label="Next">
                    <i class="next"></i>
                </a>
            </li>
        @endif
    </ul>
@endif