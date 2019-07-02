<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    </head>
    <body class="min-h-screen bg-gray-100 antialiased xl:flex xl:flex-col xl:h-screen">
        <header class="h-16 bg-white sm:flex sm:items-center sm:justify-between xl:flex-shrink-0 px-16">
            <div class="flex justify-between px-4 py-3 xl:w-72 font-bold">
                Nova Workflows
            </div>
            <nav class="sm:flex sm:items-center sm:px-4 xl:flex-1 xl:justify-between hidden">
                <div class="px-2 pt-2 pb-5 border-b border-gray-800 sm:flex sm:border-b-0 sm:py-0 sm:px-0">
                    <a href="#" class="mt-1 block px-3 py-1 rounded font-semibold text-white hover:text-gray-600 sm:mt-0 sm:text-sm sm:px-2 sm:ml-2 xl:text-gray-900">Apps</a>
                    <a href="#" class="mt-1 block px-3 py-1 rounded font-semibold text-white hover:text-gray-600 sm:mt-0 sm:text-sm sm:px-2 sm:ml-2 xl:text-gray-900">Docs</a>
                    <a href="#" class="mt-1 block px-3 py-1 rounded font-semibold text-white hover:text-gray-600 sm:mt-0 sm:text-sm sm:px-2 sm:ml-2 xl:text-gray-900">Request</a>
                    <a href="#" class="mt-1 block px-3 py-1 rounded font-semibold text-white hover:text-gray-600 sm:mt-0 sm:text-sm sm:px-2 sm:ml-2 xl:text-gray-900">Github</a>
                </div>
            </nav>
        </header>
        <div class="py-16 text-gray-700 flex h-screen items-center" style="background: url('images/hero.svg') no-repeat top right;">
            <div class="w-3/5 pl-32">
                <h1 class="text-5xl">Nova Workflows</h1>
                <h3 class="text-3xl mb-2">Build automations within Laravel Nova</h3>
                <h3 class="text-xl">A free Nova package with a growing list of integrations</h3>
                <hr>
                <div class="py-8">
                    <a href="/docs/installation" class="rounded-lg px-6 py-3 bg-white hover:bg-gray-100 md:text-lg xl:text-base text-gray-700 font-semibold leading-tight shadow-md">Get Started</a>
                </div>
            </div>
        </div>
        <div>

        </div>
    </body>
</html>
