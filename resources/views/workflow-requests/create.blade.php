@extends('layouts.app')

@section('content')
    <div class="h-screen" style="background: url(images/space.png) no-repeat top right; background-size: cover;">
        <div class="container mx-auto flex pt-6">
            <div class="w-3/5 mx-auto">
                <div class="bg-white p-12 rounded-lg">
                    @if(session()->has('status') && session('status') == 'success')
                        <h1 class="text-3xl mb-6">Success!</h1>
                        <p>Your request has been submitted and will be reviewed soon.</p>
                    @else
                        <h1 class="text-3xl mb-6">Request a workflow</h1>
                        <form action="/new" method="POST">
                            @csrf
                            <p class="pb-2 font-bold">Name of this integration</p>
                            <input type="text" value="{{ old('title') }}" name="title" class="border bg-gray-100 focus:bg-white focus:border-b w-full h-12 p-3" placeholder="Add to ACME">
                            @error('title')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                            <p class="pb-2 font-bold mt-6">URL of the service</p>
                            <input type="text" value="{{ old('url') }}" name="url" class="border bg-gray-100 focus:bg-white focus:border-b w-full h-12 p-3" placeholder="http://example.com">
                            @error('url')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                            <p class="pb-2 font-bold mt-6">Describe the expected behavior</p>
                            <textarea name="description" class="w-full border bg-gray-100 focus:bg-white focus:border-b p-3" rows="4" placeholder="It will do something amazing..">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                            <button class="px-6 py-3 text-white bg-blue-600 mt-6">Send Request</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection