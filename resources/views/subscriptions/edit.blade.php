@extends('layouts.app')

@section('content')
    <div class="h-screen">
        <div class="container mx-auto flex pt-6">
            <div class="w-3/5 mx-auto">
                <div class="bg-white p-12 rounded-lg">
                    @if(session()->has('status') && session('status') == 'success')
                        <h1 class="text-3xl mb-6">Success!</h1>
                        <p>You will no longer receive notifications.</p>
                    @else
                        <h1 class="text-3xl">Unsubscribe</h1>
                        <p class="mb-6">You will be removed from all notifications</p>
                        <form action="{{ route('subscription.destroy') }}" method="POST">
                            @csrf
                            @method('delete')
                            <input type="email" value="{{ old('email') }}" name="email" class="border bg-gray-100 focus:bg-white focus:border-b w-full h-12 p-3" placeholder="email@example.com">
                            @error('email')
                                <div class="text-red-500">{{ $errors->first('email') }}</div>
                            @enderror
                            <button type="submit" class="mt-8 rounded-full uppercase border-b-4 border-blue-700 hover:bg-blue-400 font-bold leading-loose text-sm block py-3 px-6 bg-blue-500 text-white text-center">
                                <span>Unsubscribe</span>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection