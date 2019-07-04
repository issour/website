@extends('layouts.app')

@section('content')
    <div class="bg-gray-900">
        <div class="flex container mx-auto py-8 text-white items-center">
            <div class="mr-4">
                <img src="/{{ $workflow->app->image }}" alt="Laravel {{ $workflow->app->title }} Integration" class="w-16">
            </div>
            <div>
                <h1 class="text-3xl">{{ $workflow->title }}</h1>
                <span>{{ $workflow->app->title }}</span>
            </div>
        </div>
    </div>
    <div class="container mx-auto pt-4 flex">
        <div class="w-4/5">
            <img src="/{{ $workflow->banner }}" alt="" class="w-full mb-4">
            <div class="p-2">
                <a href="https://github.com/{{ $workflow->repository }}" target="_blank" class="inline-block border border-gray-400 hover:border-gray-600 rounded-lg overflow-hidden">
                    <span class="flex">
                        <span class="bg-gray-200 py-2 px-4 font-bold align-middle">
                            Stars
                        </span>
                        <span class="bg-white py-2 px-4">
                            {{ $workflow->stars }}
                        </span>
                    </span>
                </a>
            </div>
            <div class="flex flex-wrap -mb-4 p-8 -mx-8">
                <div>{{ $workflow->description }}</div>
            </div>
            <div class="mb-3">
                <h3 class="text-3xl">Import workflow options</h3>
                <p>Running the following command will create a workflow with all the available options</p>
                <p class="mb-3">This saves time by not having to reference and type each option.</p>
                <blockquote class="bg-gray-800 text-white rounded-lg p-4">
                    php artisan workflow:import {{ $workflow->id }}
                </blockquote>
            </div>

            @if($workflow->youtube)
                <div class="mb-3">
                    <h3 class="text-3xl">Video: {{ $workflow->title }} walkthrough</h3>
                    <p class="mb-3">This video will walk you through setup & basic usage of this integration</p>
                    <iframe class="w-full" height="500" src="{{ $workflow->youtubeEmbedUrl() }}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            @endif
        </div>
        <div class="w-1/5">
            <h1>Ad</h1>
            <h1>Ad</h1>
            <h1>Ad</h1>
        </div>
    </div>
@endsection