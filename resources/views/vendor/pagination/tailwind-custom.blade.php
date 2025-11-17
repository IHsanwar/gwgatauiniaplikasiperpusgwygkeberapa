@if ($paginator->hasPages())
    <nav role="navigation" class="flex items-center space-x-1">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-default">‹</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" 
               class="px-3 py-2 bg-white border rounded-lg hover:bg-gray-100">‹</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-3 py-2 text-gray-500">...</span>
            @endif

            {{-- Array of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-2 bg-blue-600 text-white rounded-lg">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" 
                           class="px-3 py-2 bg-white border rounded-lg hover:bg-gray-100">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" 
               class="px-3 py-2 bg-white border rounded-lg hover:bg-gray-100">›</a>
        @else
            <span class="px-3 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-default">›</span>
        @endif
    </nav>
@endif
