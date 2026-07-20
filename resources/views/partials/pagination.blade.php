@if ($paginator->hasPages())
    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 border-t p-4">
        <div class="text-sm text-gray-500">
            Showing <strong>{{ $paginator->firstItem() ?? 0 }}</strong> to <strong>{{ $paginator->lastItem() ?? 0 }}</strong> of <strong>{{ $paginator->total() }}</strong> {{ $label ?? 'results' }}
        </div>
        <div class="flex items-center gap-2">
            @if ($paginator->onFirstPage())
                <span class="inline-flex rounded-md border px-3 py-1 text-sm h-10 items-center opacity-50 cursor-not-allowed">Previous</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex rounded-md border px-3 py-1 text-sm h-10 items-center hover:bg-accent hover:text-accent-foreground">Previous</a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex rounded-md border px-3 py-1 text-sm h-10 items-center hover:bg-accent hover:text-accent-foreground">Next</a>
            @else
                <span class="inline-flex rounded-md border px-3 py-1 text-sm h-10 items-center opacity-50 cursor-not-allowed">Next</span>
            @endif
        </div>
    </div>
@endif
