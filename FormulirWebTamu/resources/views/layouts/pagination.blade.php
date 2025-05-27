@if ($paginator->hasPages())
    <nav aria-label="Pagination">
        <ul class="pagination">
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <button class="btn btn-primary btn-sm pagination-btn" disabled>«</button>
                </li>
            @else
                <li class="page-item">
                    <a class="btn btn-primary btn-sm pagination-btn page-link" href="{{ $paginator->previousPageUrl() }}" data-page="{{ $paginator->currentPage() - 1 }}">«</a>
                </li>
            @endif

            @foreach ($elements as $element)
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active">
                                <button class="btn btn-primary btn-sm pagination-btn" disabled>{{ $page }}</button>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="btn btn-primary btn-sm pagination-btn page-link" href="{{ $url }}" data-page="{{ $page }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="btn btn-primary btn-sm pagination-btn page-link" href="{{ $paginator->nextPageUrl() }}" data-page="{{ $paginator->currentPage() + 1 }}">»</a>
                </li>
            @else
                <li class="page-item disabled">
                    <button class="btn btn-primary btn-sm pagination-btn" disabled>»</button>
                </li>
            @endif
        </ul>
    </nav>
@endif
