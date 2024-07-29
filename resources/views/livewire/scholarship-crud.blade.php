<div class="container">
    <x-toast event="scholarship-created" message="Scholarship created successfully!" />
    <x-toast event="scholarship-deleted" message="Scholarship deleted successfully!" />

    <div class="flex items-center justify-between mb-5">

        @can('create scholarship')
            <livewire:modals.create-scholarship />
        @endcan

        <x-search :query="$query" placeholder="Search scholarships..." />
    </div>

    <section class="mt-5 text-gray-600 body-font">
        <div class="grid grid-cols-1 gap-2 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($scholarships as $scholarship)
                <livewire:scholarship-card :scholarship="$scholarship" wire:key="scholarship-{{ $scholarship->id }}" />
            @empty
                <p>No available scholarships</p>
            @endforelse
        </div>
        {{ $scholarships->links() }}
    </section>
</div>
