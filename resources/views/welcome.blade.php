@extends('layouts.app')

@section('content')
    <div class="py-16 text-gray-700 flex h-screen items-center" style="background: url('images/hero.svg') no-repeat top right;">
        <div class="w-3/5 pl-32">
            <h1 class="text-5xl">Nova Workflows</h1>
            <h3 class="text-3xl mb-2">Build automations within Laravel Nova</h3>
            <h3 class="text-xl">A free Nova package with a growing list of integrations</h3>
            <hr>
            <div class="py-8">
                <a href="/workflows" class="rounded-lg px-6 py-3 bg-white hover:bg-gray-100 md:text-lg xl:text-base text-gray-700 font-semibold leading-tight shadow-md">Get Started</a>
            </div>
        </div>
    </div>
@endsection