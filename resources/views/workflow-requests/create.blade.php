@extends('layouts.app')

@section('content')

    <div class="h-screen" style="background: url(images/space.png) no-repeat top right; background-size: cover;">

        <div class="container mx-auto flex pt-6">

            <div class="w-3/5 mx-auto">
                <div class="bg-white p-12 rounded-lg">
                    <h1 class="text-3xl mb-6">Request a workflow</h1>
                    <form action="/new" method="POST">
                        @csrf
                        <p class="pb-2 font-bold">Name of this integration</p>
                        <input type="text" name="title" class="border bg-gray-100 focus:bg-white focus:border-b w-full mb-6 h-12 p-3" placeholder="Add to ACME">
                        <p class="pb-2 font-bold">URL of the service</p>
                        <input type="text" name="url" class="border bg-gray-100 focus:bg-white focus:border-b w-full mb-6 h-12 p-3" placeholder="http://example.com">
                        <p class="pb-2 font-bold">Describe the expected behavior</p>
                        <textarea name="description" class="w-full border bg-gray-100 focus:bg-white focus:border-b p-3 mb-6" rows="4" placeholder="It will do something amazing.."></textarea>
                        <button class="px-6 py-3 text-white bg-blue-600">Send Request</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection