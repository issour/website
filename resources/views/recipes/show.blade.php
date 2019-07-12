@extends('layouts.app')

@push('head')
    <meta name="nova" content="resource=recipes, id={{$recipe->id}}" />
    <link rel="stylesheet" href="{{ mix('css/markdown.css') }}">
@endpush

@section('content')
    <div class="container mx-auto flex pt-6">
        <div class="w-4/5">
            <div class="bg-white p-12 rounded">
                <div class="flex mb-6">
                    <div class="mr-4">
                        <img src="/{{ $workflow->app->image }}" alt="Laravel {{ $workflow->app->title }} Integration" class="w-16 p-2 rounded  bg-white">
                    </div>
                    <div class="border-b pb-6">
                        <h1 class="text-3xl">{{ $recipe->title }}</h1>
                        <a href="{{ route('workflows.show', $workflow->slug) }}">{{ $workflow->app->title }} / {{ $workflow->title }}</a>
                    </div>
                </div>
                <div class="markdown-body pl-20">
                    {!! $recipe->content !!}
                </div>
            </div>
        </div>
    </div>
@endsection