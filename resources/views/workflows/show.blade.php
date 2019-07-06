@extends('layouts.app')

@push('head')
<meta name="nova" content="resource=workflows, id={{$workflow->id}}" />
<link rel="stylesheet" href="{{ mix('css/markdown.css') }}">
@endpush

@section('content')
    <div>
        <div class="flex container mx-auto py-10 justify-between text-gray-700 items-center">
            <div class="flex w-4/5 justify-between  items-baseline">
                <div class="flex">
                    <div class="mr-4">
                        <img src="/{{ $workflow->app->image }}" alt="Laravel {{ $workflow->app->title }} Integration" class="w-16 p-2 rounded  bg-white">
                    </div>
                    <div>
                        <h1 class="text-3xl">{{ $workflow->title }}</h1>
                        <span>{{ $workflow->app->title }}</span>
                    </div>
                </div>
                <div>
                    <a href="https://github.com/{{ $workflow->repository }}" target="_blank" class="inline-block border border-gray-400 hover:border-gray-600 rounded-lg overflow-hidden">
                        <span class="flex text-gray-900">
                            <span class="bg-gray-200 py-2 px-4 font-bold align-middle">
                                Stars
                            </span>
                            <span class="bg-white py-2 px-4 border-l">
                                {{ $workflow->stars }}
                            </span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="container mx-auto flex">
        <div class="w-4/5">
            <img src="/{{ $workflow->banner }}" alt="" class="w-full mb-4">
            <div id="overview" class="mb-6">
                <div class="markdown-body bg-white p-12 rounded">{!! $workflow->description !!}</div>
            </div>
            <div id="installation" class="mb-6">
                <h3 class="text-3xl mb-3">Installation</h3>
                <blockquote class="bg-gray-800 text-white rounded-lg p-4">
                    composer require {{ $workflow->repository }}
                </blockquote>

                <div class="markdown-body bg-white p-12 rounded">{!! $workflow->installation !!}</div>
            </div>
            <div id="options" class="mb-6">
                <h3 class="text-3xl mb-3">Options</h3>
                <div class="mb-4 relative rounded-t-lg rounded-b-lg shadow overflow-hidden" style="background-clip: border-box;">
                    <div class="flex border-b">
                        <div class="w-48 uppercase font-bold text-xs tracking-wide px-3 py-3">
                            Key
                        </div>
                        <div class="flex-grow uppercase font-bold text-xs tracking-wide px-3 py-3 border-l">
                            Value
                        </div>
                    </div>

                    @foreach($workflow->options as $key => $value)
                        <div class="bg-white flex border-b">
                            <div class="w-48 font-mono text-xs tracking-wide px-3 py-3">
                                {{ $key }}
                            </div>
                            <div class="flex-grow font-mono text-xs tracking-wide px-3 py-3 border-l">
                                {{ $value }}
                            </div>
                        </div>
                    @endforeach
                </div>
                <p class="mb-6">For a complete reference of the bracket syntax, see: <a href="https://razorphp.com" target="_blank">RazorPHP</a></p>

                <h3 class="text-3xl mb-3">Import options</h3>
                <p>Running the following command will create a workflow with all the available options</p>
                <p class="mb-6">This saves time by not having to reference and type each option.</p>
                <blockquote class="bg-gray-800 text-white rounded-lg p-4">
                    php artisan workflow:import {{ $workflow->id }}
                </blockquote>
            </div>

            <div id="video" class="mb-6">
                <h3 class="text-3xl mb-3">Video walkthrough</h3>
                <div class="bg-white p-4 rounded">
                    <iframe class="w-full mb-4" height="500" src="{{ $workflow->youtubeEmbedUrl() }}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    <h2>{{ $workflow->app->title }} / {{ $workflow->title }} Video</h2>
                    <h4>See the '{{ $workflow->title }}' workflow in action</h4>
                    <p class="mb-6">This video will walk you through setup & basic usage of this integration</p>
                </div>
            </div>

            <div id="recipies" class="mb-6">
                <h3 class="text-3xl mb-3">Recipies</h3>
                <h4>Ideas on using the '{{ $workflow->title }}' workflow</h4>
            </div>
        </div>
        <div class="w-1/5">
            <div class="fixed px-6">
                <a href="#top" class="block text-xl hover:text-gray-600 select-none">Overview</a>
                <a href="#installation" class="block text-xl hover:text-gray-600 select-none">Installation</a>
                <a href="#options" class="block text-xl hover:text-gray-600 select-none">Options</a>
                <a href="#video" class="block text-xl hover:text-gray-600 select-none">Video</a>
                <a href="#recipies" class="block text-xl hover:text-gray-600 select-none">Recipies</a>
            </div>
        </div>
    </div>
@endsection