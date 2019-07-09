<div class="py-8">
    <div class="container mx-auto flex">
        <div class="flex w-1/5 relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-current text-gray-600">
                    <path d="M16.32 14.9l1.1 1.1c.4-.02.83.13 1.14.44l3 3a1.5 1.5 0 0 1-2.12 2.12l-3-3a1.5 1.5 0 0 1-.44-1.14l-1.1-1.1a8 8 0 1 1 1.41-1.41l.01-.01zM10 16a6 6 0 1 0 0-12 6 6 0 0 0 0 12z"></path>
                </svg>
            </div>
            <form action="{{ request()->url() }}">
                <input type="search" placeholder="Search workflows" name="search" value="{{ request('search') }}" class="block w-full border border-transparent bg-white focus:outline-none  focus:border-gray-300 text-gray-900 rounded-lg pl-10 pr-4 py-2">
            </form>
        </div>

        <div class="flex w-2/5 px-8 py-2 justify-center">
            <a href="" class="pr-8">All</a>
            <a href="" class="pr-8">General</a>
            <a href="" class="pr-8">Social</a>
            <a href="" class="pr-8">Accounting</a>
            <a href="" class="pr-8">Crm</a>
            <a href="" class="pr-8">More</a>
        </div>

        <div class="w-1/5">
            <div class="rounded-full bg-gray-300 border overflow-hidden flex text-center">
                <a href="#" class="block w-1/2 border-r py-3">
                    All
                </a>
                <a href="#" class="block w-1/2 border-r py-3 bg-gray-400">
                    Live
                </a>
                <a href="#" class="block w-1/2 py-3">
                    Staged
                </a>
            </div>
        </div>

        <div class="w-1/5">
            <a href="/new" class="rounded-full uppercase border-b-4 border-blue-700 hover:bg-blue-400 font-bold leading-loose text-sm block mx-8 py-3 bg-blue-500 text-white text-center">
                <span>Request App</span>
            </a>
        </div>
    </div>
</div>