@extends('layouts.app')

@section('content')
    <div class="bg-gray-900">
        <div class="container mx-auto py-8">
            <h1 class="text-3xl text-white">{{ $workflow->title }}</h1>
        </div>
    </div>
    <div class="container mx-auto pt-4 flex">
        <div class="w-4/5">
            <img src="/{{ $workflow->banner }}" alt="" class="w-full mb-4">
            <div class="flex flex-wrap -mb-4 p-8 -mx-8">
                <div>{{ $workflow->description }}</div>
            </div>
        </div>
        <div class="w-1/5">
            <h1>Ad</h1>
            <h1>Ad</h1>
            <h1>Ad</h1>
        </div>
    </div>
@endsection