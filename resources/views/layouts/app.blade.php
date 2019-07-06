<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Nova Workflows</title>
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        @stack('head')
    </head>
    <body id="top" class="min-h-screen bg-gray-100 antialiased">
        <header class="h-20 bg-white sm:flex sm:items-center sm:justify-between xl:flex-shrink-0 px-16">
            <div class="flex justify-between px-4 py-3 xl:w-72 font-bold">
                <a href="/" class="flex items-center">

                    <svg class="mr-3" width="24px" height="24px" viewBox="0 0 16 16" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <image id="128" x="0" y="0" width="16" height="16" xlink:href="data:image/png;base64,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"></image>
                        </g>
                    </svg>
                    <span>Nova Workflows</span>
                </a>
            </div>
            <nav class="sm:flex sm:items-center sm:px-4 xl:flex-1 xl:justify-between hidden">
                <div class="px-2 pt-2 pb-5 border-b border-gray-800 sm:flex sm:border-b-0 sm:py-0 sm:px-0">
                    <a href="/workflows" class="mt-1 block px-3 py-1 rounded font-semibold text-white hover:text-gray-600 sm:mt-0 sm:text-sm sm:px-2 sm:ml-2 xl:text-gray-900">Apps</a>
                    <a href="#" class="mt-1 block px-3 py-1 rounded font-semibold text-white hover:text-gray-600 sm:mt-0 sm:text-sm sm:px-2 sm:ml-2 xl:text-gray-900">Docs</a>
                    <a href="#" class="mt-1 block px-3 py-1 rounded font-semibold text-white hover:text-gray-600 sm:mt-0 sm:text-sm sm:px-2 sm:ml-2 xl:text-gray-900">Request</a>
                    <a href="#" class="mt-1 block px-3 py-1 rounded font-semibold text-white hover:text-gray-600 sm:mt-0 sm:text-sm sm:px-2 sm:ml-2 xl:text-gray-900">Github</a>
                </div>
            </nav>
        </header>

        @yield('content')
    </body>
</html>
