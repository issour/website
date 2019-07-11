<div class="bg-white shadow-lg">
    @if($workflow->image)
        <div class="relative h-64">
            <a href="{{ route('workflows.show', $workflow->slug) }}">
                <img src="{{ $workflow->asset('300x200.jpg') }}" alt="{{ $workflow->title }}" class="absolute inset-0 h-full w-full object-cover">
            </a>
        </div>
    @endif
    <div class="p-6">
        <div class="w-full">
            <a href="{{ route('workflows.show', $workflow->slug) }}">
                <span>{{ $workflow->app->title }}</span>
                <h3 class="text-2xl">{{ $workflow->title }}</h3>
            </a>
            <p class="truncate nowrap">{{ $workflow->blurb }}</p>
        </div>
        <div class="w-full pt-4">
            <span class="bg-gray-200 py-1 px-3 font-bold align-middle">
                {{ ($workflow->status == 'published') ? 'Stars' : 'Votes' }}
            </span>
            <span class="bg-white py-1 px-3 border-l">
                {{ $workflow->stars }}
            </span>
        </div>
    </div>
</div>