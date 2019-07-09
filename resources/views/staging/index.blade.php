@extends('layouts.app')

@section('content')

    @include('layouts.filter')

    <div class="container mx-auto">
        <div class="flex flex-wrap -mx-4">
            @foreach($workflows as $workflow)
                <div class="w-1/3 px-4 pb-4 mb-6">
                    @include('layouts.card', ['workflow' => $workflow])
                </div>
            @endforeach

            @if(count($workflows) == 0)
                <h1 class="text-4xl">No workflows found</h1>
            @endif
        </div>
    </div>
@endsection