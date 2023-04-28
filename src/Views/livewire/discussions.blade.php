<div class="relative mx-auto {{ config('discussions.styles.container_max_width') }}">
    <div class="space-y-6">
        <h1 class="text-3xl font-bold tracking-tighter">Discussions</h1>

        <top-bar-discussions class="flex justify-between w-full space-x-3 h-9">
            <search-discussions class="relative flex items-center w-full h-full">
                <div class="absolute left-0 flex items-center justify-center h-full pl-2.5 pr-1">
                    <svg class="w-4 h-4 text-gray-400 -translate-y-px fill-current" viewBox="0 0 16 16" version="1.1"
                        data-view-component="true">
                        <path
                            d="M10.68 11.74a6 6 0 0 1-7.922-8.982 6 6 0 0 1 8.982 7.922l3.04 3.04a.749.749 0 0 1-.326 1.275.749.749 0 0 1-.734-.215ZM11.5 7a4.499 4.499 0 1 0-8.997 0A4.499 4.499 0 0 0 11.5 7Z">
                        </path>
                    </svg>
                </div>
                <input wire:model="search" type="text" placeholder="Search all discussions"
                    class="flex focus:border-neutral-900 focus:outline-none focus:ring-neutral-900 items-center w-full h-full pl-8 pr-2 text-sm border border-gray-300 {{ config('discussions.styles.rounded') }}" />
            </search-discussions>

            <button-category
                class="flex-shrink-0 relative flex items-center justify-between h-full px-3.5 overflow-hidden bg-neutral-50 hover:bg-neutral-100 border border-gray-300 cursor-pointer text-sm font-medium {{ config('discussions.styles.rounded') }}">
                Category<svg class="w-4 h-4 translate-x-0.5" aria-hidden="true" viewBox="0 0 16 16" version="1.1"
                    data-view-component="true" class="octicon octicon-triangle-down">
                    <path
                        d="m4.427 7.427 3.396 3.396a.25.25 0 0 0 .354 0l3.396-3.396A.25.25 0 0 0 11.396 7H4.604a.25.25 0 0 0-.177.427Z">
                    </path>
                </svg>
            </button-category>

            <div x-data="{ open: false }" class="relative">
                <button-category @click="open = !open"
                    class="flex-shrink-0 flex items-center justify-between h-full px-3.5 overflow-hidden bg-neutral-50 hover:bg-neutral-100 border border-gray-300 cursor-pointer text-sm font-medium {{ config('discussions.styles.rounded') }}">
                    Sort<svg class="w-4 h-4 translate-x-0.5" aria-hidden="true" viewBox="0 0 16 16" version="1.1"
                        data-view-component="true" class="octicon octicon-triangle-down">
                        <path
                            d="m4.427 7.427 3.396 3.396a.25.25 0 0 0 .354 0l3.396-3.396A.25.25 0 0 0 11.396 7H4.604a.25.25 0 0 0-.177.427Z">
                        </path>
                    </svg>
                </button-category>
                <div x-show="open" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-95" @click.away="open = false" x-cloak
                    class="absolute z-10 w-56 mt-2 origin-top-left rounded-md shadow-lg">
                    <div class="px-2 py-2 bg-white rounded-md shadow dark-mode:bg-gray-800">
                        <button @click="open=false" wire:click.prevent="updateSortOrder('desc')"
                            class="block px-4 py-2 text-sm text-gray-700 transition-colors duration-150 hover:text-gray-900 dark-mode:hover:text-gray-200">Newest</button>
                        <button @click="open=false" wire:click.prevent="updateSortOrder('asc')"
                            class="block px-4 py-2 text-sm text-gray-700 transition-colors duration-150 hover:text-gray-900 dark-mode:hover:text-gray-200">Oldest</button>
                    </div>
                </div>
            </div>

            <button-category onclick="window.dispatchEvent(new CustomEvent('discussion-new-open'))"
                class="flex-shrink-0 relative flex items-center justify-between h-full px-3.5 overflow-hidden bg-green-600 border border-green-500 text-white cursor-pointer text-sm font-medium {{ config('discussions.styles.rounded') }}">
                New {{ trans('discussions::intro.titles.discussion') }}
            </button-category>
        </top-bar-discussions>
        @include('discussions::partials.guest-auth-message')
        @if (session()->has('message'))
            <div class="p-4 mb-4 text-white bg-green-500 {{ config('discussions.styles.rounded') }}">
                {{ session('message') }}
            </div>
        @endif
        <div class="relative flex">
            @if (config('discussions.show_categories'))
                @include('discussions::partials.categories')
            @endif
            <div class="w-full space-y-2">
                @forelse ($discussions as $discussion)
                    @if (!$loop->first)
                        <div class="w-full h-px bg-gray-200"></div>
                    @endif
                    <div class="py-2 flex items-start @if (config('discussions.styles.rounded') == 'rounded-full') {{ 'rounded-xl' }}@else{{ config('discussions.styles.rounded') }} @endif"
                        wire:key="{{ $discussion->id }}">
                        @include('discussions::partials.discussion-avatar', ['user' => $discussion->user])
                        <div class="relative flex flex-col justify-start w-full ml-3">
                            <a href="{{ route('discussion', $discussion->slug) }}"
                                class="pt-px mb-1 font-semibold leading-tight tracking-tight text-gray-800 hover:text-blue-500">{{ $discussion->title }}</a>
                            <p class="text-xs leading-none text-gray-500">
                                @lang('discussions::messages.discussion.posted_by') {{ $discussion->user->name }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="flex justify-center">
                        <p class="text-gray-500">@lang('discussions::messages.discussion.no_discussions')</p>
                    </div>
                @endforelse
                @if ($discussions->hasMorePages())
                    <div class="flex justify-center">
                        <button wire:click="loadMore"
                            class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                            @lang('discussions::messages.discussion.load_more')
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @auth
        <div x-data="{ open: false }" x-show="open" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-y-0"
            x-transition:leave-end="translate-y-full" @discussion-new-open.window="open = true"
            class="fixed bottom-0 flex items-center justify-end w-full {{ config('discussions.styles.container_max_width') }} mx-auto">
            <div class="flex-shrink-0 mr-4 bg-transparent {{ config('discussions.styles.sidebar_width') }}"></div>
            <div class="relative bottom-0 w-full bg-white border border-b-0 border-gray-300 rounded-t-xl shadow-3xl"
                x-cloak>
                <div class="flex items-start p-5 space-x-1">
                    @include('discussions::partials.discussion-avatar', ['user' => auth()->user()])
                    <div class="relative flex flex-col w-full">
                        <div class="pr-10">
                            <input wire:model="title" type="text" placeholder="@lang('discussions::messages.editor.title')"
                                class="w-full py-2 pr-3 font-medium border-0 focus:ring-0 focus:outline-none">
                        </div>
                        <textarea wire:model="content" placeholder="@lang('discussions::messages.editor.content')"
                            class="w-full h-32 py-2 pr-3 text-sm border-0 focus:ring-0 focus:outline-none"></textarea>
                    </div>
                </div>
                <div
                    class="relative flex items-center justify-between px-5 pt-4 pb-3 text-xs font-semibold border-t border-gray-200 hover:text-gray-700">
                    <div x-data="{ dropdownOpen: false }" @click.away="dropdownOpen = false">
                        <button @click="dropdownOpen = !dropdownOpen"
                            class="flex items-center px-4 py-2 space-x-1 font-medium text-gray-500 bg-gray-100 rounded-full hover:bg-gray-200/60">
                            @if ($category_slug)
                                <span>{{ Foundationapp\Discussions\Helpers\Category::name($category_slug) }}</span>
                            @else
                                <span>Select a Category</span>
                            @endif
                            <svg class="w-4 h-4 rotate-180 translate-y-px" aria-hidden="true" viewBox="0 0 16 16"
                                version="1.1" data-view-component="true">
                                <path
                                    d="m4.427 7.427 3.396 3.396a.25.25 0 0 0 .354 0l3.396-3.396A.25.25 0 0 0 11.396 7H4.604a.25.25 0 0 0-.177.427Z">
                                </path>
                            </svg>
                        </button>
                        <div x-show="dropdownOpen"
                            class="absolute w-48 mb-2 bg-white rounded-md shadow-lg bottom-full ring-1 ring-black ring-opacity-5">
                            <div class="py-1" role="menu" aria-orientation="vertical"
                                aria-labelledby="options-menu">
                                @foreach (config('discussions.categories') as $index => $category)
                                    <button wire:click="setCategory('{{ $index }}')"
                                        @click="dropdownOpen = !dropdownOpen"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                        role="menuitem">{{ Foundationapp\Discussions\Helpers\Category::name($index) }}</button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="relative flex items-center space-x-2">
                        <button @click="open=false"
                            class="px-4 py-2 text-gray-600 hover:text-gray-700 bg-gray-200 {{ config('discussions.styles.rounded') }}">@lang('discussions::messages.words.cancel')</button>
                        <button wire:click="createDiscussion"
                            class="px-4 py-2 text-white bg-green-600 {{ config('discussions.styles.rounded') }}">@lang('discussions::messages.words.submit')</button>
                    </div>
                </div>

                <div class="absolute top-0 right-0 pr-1">
                    <div @click="open = false" class="block p-3 cursor-pointer">&times;</div>
                </div>
            </div>
        </div>
    @endauth

</div>
