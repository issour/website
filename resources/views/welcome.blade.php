@extends('layouts.app')

@section('content')
        <div class="py-16 flex h-screen items-center text-white" style="background: #1b53ab url(images/hero.png) no-repeat 139% -58px;background-size: 70%;background-attachment: fixed;">
            <div class="w-3/5 pl-32">
                <h1 class="text-6xl">Nova Workflows</h1>
                <h3 class="text-4xl mb-2">Add automations to Laravel Nova</h3>
                <h3 class="text-xl">A free Nova package for 3rd party integrations</h3>
                <hr>
                <div class="py-8">
                    <a href="/workflows" class="rounded-lg px-6 py-3 bg-white hover:bg-gray-100 md:text-lg xl:text-base text-gray-700 font-semibold leading-tight shadow-md">Get Started</a>
                </div>
            </div>
        </div>

        <div class="py-16 text-gray-700 flex h-screen items-center" style="background: url('images/hero.svg') no-repeat top right;">
            <div class="w-3/5 pl-32">
                <h1 class="text-6xl">Nova Workflows</h1>
                <h3 class="text-4xl mb-2">Add automations to Laravel Nova</h3>
                <h3 class="text-xl">A free Nova package for 3rd party integrations</h3>
                <hr>
                <div class="py-8">
                    <a href="/workflows" class="rounded-lg px-6 py-3 bg-white hover:bg-gray-100 md:text-lg xl:text-base text-gray-700 font-semibold leading-tight shadow-md">Get Started</a>
                </div>
            </div>
        </div>

        <div class="py-16 text-white flex items-center" style="background: url('images/space.png') no-repeat top right; background-size: cover;">
            <div class="w-2/5 mx-auto text-center">
                <h1 class="text-6xl">Nova Workflows</h1>
                <h3 class="text-4xl mb-2">Add automations to Laravel Nova</h3>
                <h3 class="text-xl">A free Nova package for 3rd party integrations</h3>
            </div>
        </div>
@endsection