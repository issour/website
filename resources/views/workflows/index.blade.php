@extends('layouts.app')

@section('content')

    <div class="container mx-auto pt-4">
        <div class="hidden xl:block xl:relative xl:max-w-xs xl:w-full">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-current text-gray-600">
                    <path d="M16.32 14.9l1.1 1.1c.4-.02.83.13 1.14.44l3 3a1.5 1.5 0 0 1-2.12 2.12l-3-3a1.5 1.5 0 0 1-.44-1.14l-1.1-1.1a8 8 0 1 1 1.41-1.41l.01-.01zM10 16a6 6 0 1 0 0-12 6 6 0 0 0 0 12z"></path>
                </svg>
            </div>
            <form action="/workflows">
                <input placeholder="Search workflows" name="search" value="{{ request('search') }}" class="block w-full border border-transparent bg-white focus:outline-none  focus:border-gray-300 text-gray-900 rounded-lg pl-10 pr-4 py-2">
            </form>
        </div>
        <div class="flex flex-wrap -mb-4 p-8 -mx-8">
            @foreach($workflows as $workflow)
                <div class="w-1/4 mb-4 border rounded p-4 bg-white ">
                    <a href="{{ route('workflows.show', $workflow) }}">
                        @if($workflow->image)
                            <img src="{{ $workflow->image }}" alt="{{ $workflow->title }}" class="mb-2">
                        @endif
                        <h3 class="text-2xl">{{ $workflow->title }}</h3>
                        <p>{{ $workflow->blurb }}</p>
                    </a>
                </div>
            @endforeach

            @if(count($workflows) == 0)
                <h1 class="text-4xl">No workflows found</h1>
            @endif
        </div>
    </div>
@endsection