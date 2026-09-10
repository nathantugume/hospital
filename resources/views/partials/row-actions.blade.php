<details class="row-actions">
    <summary aria-label="Actions for {{ $record->full_name }}">@include('partials.icon', ['icon' => 'more', 'iconClass' => 'h-4 w-4'])</summary>
    <div class="row-actions-menu">
        <a href="{{ route('web.'.$entity.'.show', $record) }}">View Profile</a>
        @can('update', $record)<a href="{{ route('web.'.$entity.'.edit', $record) }}">Edit Details</a>@endcan
    </div>
</details>
