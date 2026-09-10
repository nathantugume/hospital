<div class="flex flex-col sm:flex-row items-center justify-between gap-3 border-t p-4 bg-gray-50">
    <div class="text-xs text-gray-500">Showing <strong>{{ $paginator->firstItem() ?? 0 }}</strong> to <strong>{{ $paginator->lastItem() ?? 0 }}</strong> of <strong>{{ $paginator->total() }}</strong> {{ $label ?? 'entries' }}</div>
    <nav aria-label="Pagination" class="flex items-center gap-1">
        @if($paginator->onFirstPage())<span aria-disabled="true" class="inline-flex rounded-md border px-2 py-1 text-xs h-8 items-center opacity-50">‹ Prev</span>
        @else<a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex rounded-md border px-2 py-1 text-xs h-8 items-center hover:bg-accent">‹ Prev</a>@endif
        @foreach(range(max(1, $paginator->currentPage() - 2), min($paginator->lastPage(), $paginator->currentPage() + 2)) as $page)
            @if($page === $paginator->currentPage())<span aria-current="page" class="inline-flex rounded-md border px-3 py-1 text-sm h-8 items-center bg-indigo-600 text-white">{{ $page }}</span>
            @else<a href="{{ $paginator->url($page) }}" aria-label="Page {{ $page }}" class="inline-flex rounded-md border px-3 py-1 text-sm h-8 items-center hover:bg-accent">{{ $page }}</a>@endif
        @endforeach
        @if($paginator->hasMorePages())<a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex rounded-md border px-2 py-1 text-xs h-8 items-center hover:bg-accent">Next ›</a>
        @else<span aria-disabled="true" class="inline-flex rounded-md border px-2 py-1 text-xs h-8 items-center opacity-50">Next ›</span>@endif
    </nav>
    <span class="text-xs text-gray-500">Rows: {{ $paginator->perPage() }}</span>
</div>
