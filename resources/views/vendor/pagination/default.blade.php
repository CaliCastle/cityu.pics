@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled"><span style="border: none;background: transparent;color: #bbb;"><i class="fa fa-chevron-left"></i></span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" class="waves-effect" rel="prev" style="border: none;color: #fff;background: transparent;"><i class="fa fa-chevron-left"></i></a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled" style="border: none;background: none;color: #bbb;"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active"><span style="background: #4794c1;">{{ $page }}</span></li>
                    @else
                        <li><a class="waves-effect" href="{{ $url }}" style="border: none;color: #fff;background: transparent;">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next" class="waves-effect" style="border: none;color: #fff;background: transparent;"><i class="fa fa-chevron-right"></i></a></li>
        @else
            <li class="disabled"><span style="border: none;background: transparent;color: #bbb;"><i class="fa fa-chevron-right"></i></span></li>
        @endif
    </ul>
@endif
