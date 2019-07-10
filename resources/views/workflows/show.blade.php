@extends('layouts.app')

@push('head')
<meta name="nova" content="resource=workflows, id={{$workflow->id}}" />
<link rel="stylesheet" href="{{ mix('css/markdown.css') }}">
@endpush

@section('content')
    <div>
        <div class="flex container mx-auto pt-8 justify-between text-gray-700 items-top">
            <div class="flex w-4/5 justify-between">
                <div class="flex">
                    <div class="mr-4">
                        <img src="/{{ $workflow->app->image }}" alt="Laravel {{ $workflow->app->title }} Integration" class="w-16 p-2 rounded  bg-white">
                    </div>
                    <div>
                        <h1 class="text-3xl">{{ $workflow->title }}</h1>
                        <span>{{ $workflow->app->title }}</span>
                    </div>
                </div>
                <div class="flex items-center">
                    @if($workflow->inStaging())
                        <span class="inline-block bg-gray-900 mr-6 px-4 py-2 text-white" title="Not ready for production use">
                            Staging
                        </span>
                    @endif
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
            <div class="w-1/5">
                <a href="/new" class="rounded-full uppercase border-b-4 border-blue-700 hover:bg-blue-400 font-bold leading-loose text-sm block mx-8 py-3 bg-blue-500 text-white text-center">
                    <span>Request App</span>
                </a>
            </div>
        </div>
    </div>
    <div class="container mx-auto flex">
        <div class="w-4/5">
            @if($workflow->banner)
                <img src="{{ $workflow->asset('900x300.jpg') }}" alt="" class="w-full mb-4">
            @endif
            @if($workflow->inStaging())
                <div class="p-12 mb-6 bg-gray-900 text-white flex">
                    <div class="w-1/2">
                        <h3 class="text-3xl mb-3">Staging: Not Launched</h3>
                        <p>This integration has not yet been launched</p>
                    </div>
                    <div class="w-1/2">
                        <h3 class="text-3xl mb-3">{{ $workflow->votes }} votes</h3>
                        <p>The most voted for integrations get priorty</p>
                        @if(auth()->check() && !is_null($vote))
                        <p class="mb-4">You voted on: {{ $vote->created_at->format('m/d/Y') }}</p>
                        @elseif(auth()->check())
                        <p class="mb-4">Click below to vote:</p>
                        <form action="{{ route('votes.store', $workflow) }}" method="POST">
                            @csrf
                            <button class="bg-blue-500 text-white px-4 py-2 rounded-full">Vote</button>
                        </form>
                        @else
                        <p class="mb-4">You must be logged in to vote:</p>
                        <a href="/login/github" class="bg-gray-600 text-white px-4 py-2 rounded-full">Login with Github</a>
                        @endif
                    </div>
                </div>
            @endif
            <div id="overview" class="mb-6">
                <div class="markdown-body bg-white p-12 rounded">{!! $workflow->description !!}</div>
            </div>
            <div id="installation" class="mb-6 bg-white p-12 rounded">
                <h3 class="text-3xl mb-3">Installation</h3>
                <blockquote class="bg-gray-800 text-white rounded-lg p-4">
                    composer require {{config('services.github.owner')}}/{{ $workflow->repository }}
                </blockquote>

                <div class="markdown-body pt-12">{!! $workflow->installation !!}</div>
            </div>

            @if($workflow->options)
            <div id="options" class="mb-6 bg-white p-12 rounded">
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

                <blockquote class="bg-gray-800 text-white rounded-lg p-4 mb-3">
                    php artisan nova:workflow {{ $workflow->id }}
                </blockquote>
                <p class="mb-6">This command will create a workflow with the available options in your Nova project</p>

                <h3 class="text-2xl mb-3">Option Syntax</h3>
                <p>The bracket syntax provides alot of power for how the workflows populate outcomes</p>
                <p>The values are extracted from the trigger, ie "When a new user is created" a {user} is available</p>
                <p class="mb-6">Pipe values into other methods for even more flexibility: { user.orders | sum:total }</p>
                <p class="mb-6">For a complete reference of the bracket syntax, see: <a href="https://razorphp.com" target="_blank" class="bg-gray-100 border text-blue-500  font-bold rounded-full  py-1 px-3">RazorPHP</a></p>

            </div>
            @endif

            @if($workflow->youtube)
            <div id="video" class="mb-6">
                <h3 class="text-3xl mb-3">Video walkthrough</h3>
                <div class="bg-white p-4 rounded">
                    <iframe class="w-full mb-4" height="500" src="{{ $workflow->youtubeEmbedUrl() }}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    <h2>{{ $workflow->app->title }} / {{ $workflow->title }} Video</h2>
                    <h4>See the '{{ $workflow->title }}' workflow in action</h4>
                    <p class="mb-6">This video will walk you through setup & basic usage of this integration</p>
                </div>
            </div>
            @endif

            @if(count($recipes))
            <div id="recipes" class="mb-6 bg-white p-10">
                <h3 class="text-3xl">Recipes</h3>
                <h4 class="mb-3">Ideas on using the '{{ $workflow->title }}' workflow</h4>

                @foreach($recipes as $recipe)
                    <div class="border mb-3 rounded p-6 flex items-center">
                        <img src="/{{ $workflow->image }}" alt="Laravel {{ $workflow->app->title }} Integration" class="w-16 p-2 rounded  bg-white">
                        <a href="{{ route('recipes.show', $recipe->slug) }}" class="text-2xl ml-2">
                            {{ $recipe->title }}
                            <span class="block text-base text-gray-600">{{ $workflow->app->title }} / {{ $workflow->title }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
            @endif
        </div>
        <div class="w-1/5">
            <div class="fixed px-6">
                <a href="#top" class="block text-xl hover:text-gray-600 select-none">Overview</a>
                <a href="#installation" class="block text-xl hover:text-gray-600 select-none">Installation</a>
                @if($workflow->options)
                <a href="#options" class="block text-xl hover:text-gray-600 select-none">Options</a>
                @endif
                @if($workflow->youtube)
                <a href="#video" class="block text-xl hover:text-gray-600 select-none">Video</a>
                @endif
                @if(count($recipes))
                <a href="#recipes" class="block text-xl hover:text-gray-600 select-none">Recipes</a>
                @endif
            </div>
        </div>
    </div>
@endsection