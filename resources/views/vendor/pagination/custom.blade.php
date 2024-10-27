@if ($paginator->hasPages())
    {{-- <ul class="pagination">
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <a class="page-link" href="javascript:void(0)" aria-label="Previous">
                    <span class="material-symbols-outlined">chevron_left</span>
                </a>
            </li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev"><span class="material-symbols-outlined">chevron_left</span></a></li>
        @endif
    </ul> --}}
    <div class="list-table-footer d-flex justify-content-between align-items-center">
        <div class="list-table-per-page">
            <span class="form-label">Hiển thị kết quả</span>
            <select class="form-select d-inline-block" name="" id="">
                <option selected>15</option>
                <option value="">20</option>
                <option value="">30</option>
                <option value="">50</option>
            </select>
        </div>
        <nav aria-label="Page navigation">
            <ul class="pagination">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li class="disabled"><span>{{ $element }}</span></li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active" aria-current="page">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <li><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                            <span class="material-symbols-outlined">chevron_right</span>
                        </a>
                    </li>
                @else
                    <li class="disabled">
                        <a class="page-link" href="javascript:void(0);" aria-label="Next">
                            <span class="material-symbols-outlined">chevron_right</span>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@endif