<div class="relative">
    <div class="space-y-5">
        <h1 class="text-4xl font-bold tracking-tighter">Discussions</h1>

        <top-bar-discussions class="flex justify-between w-full space-x-3 h-9">
            <search-discussions class="relative flex items-center w-full h-full">
                <div class="absolute left-0 flex items-center justify-center h-full pl-2.5 pr-1">
                    <svg class="w-4 h-4 text-gray-400 -translate-y-px fill-current" viewBox="0 0 16 16" version="1.1" data-view-component="true"><path d="M10.68 11.74a6 6 0 0 1-7.922-8.982 6 6 0 0 1 8.982 7.922l3.04 3.04a.749.749 0 0 1-.326 1.275.749.749 0 0 1-.734-.215ZM11.5 7a4.499 4.499 0 1 0-8.997 0A4.499 4.499 0 0 0 11.5 7Z"></path></svg>
                </div>
                <input name="search" type="text" placeholder="Search all discussions" class="flex focus:border-neutral-900 focus:outline-none focus:ring-neutral-900 items-center w-full h-full pl-8 pr-2 text-sm border border-gray-300 {{ config("discussions.styles.rounded") }}" />
            </search-discussions>

            <button-category class="flex-shrink-0 relative flex items-center justify-between h-full px-3.5 overflow-hidden bg-neutral-50 hover:bg-neutral-100 border border-gray-300 cursor-pointer text-sm font-medium {{ config("discussions.styles.rounded") }}">
                Category<svg class="w-4 h-4 translate-x-0.5" aria-hidden="true" viewBox="0 0 16 16" version="1.1" data-view-component="true" class="octicon octicon-triangle-down"><path d="m4.427 7.427 3.396 3.396a.25.25 0 0 0 .354 0l3.396-3.396A.25.25 0 0 0 11.396 7H4.604a.25.25 0 0 0-.177.427Z"></path></svg>
            </button-category>

            <button-category class="flex-shrink-0 relative flex items-center justify-between h-full px-3.5 overflow-hidden bg-neutral-50 hover:bg-neutral-100 border border-gray-300 cursor-pointer text-sm font-medium {{ config("discussions.styles.rounded") }}">
                Sort By<svg class="w-4 h-4 translate-x-0.5" aria-hidden="true" viewBox="0 0 16 16" version="1.1" data-view-component="true" class="octicon octicon-triangle-down"><path d="m4.427 7.427 3.396 3.396a.25.25 0 0 0 .354 0l3.396-3.396A.25.25 0 0 0 11.396 7H4.604a.25.25 0 0 0-.177.427Z"></path></svg>
            </button-category>

            <button-category onclick="window.dispatchEvent(new CustomEvent('discussion-new-open'))" class="flex-shrink-0 relative flex items-center justify-between h-full px-3.5 overflow-hidden bg-neutral-900 hover:bg-neutral-950 border border-neutral-700 text-white cursor-pointer text-sm font-medium {{ config("discussions.styles.rounded") }}">
                New {{ trans('discussions::intro.titles.discussion') }}            
            </button-category>
        </top-bar-discussions>
        @guest
            <div class="p-4 mb-4 text-neutral-700 bg-gray-100 {{ config("discussions.styles.rounded") }}">
                @lang('discussions::intro.please_login')
            </div>
        @endauth

        <div class="space-y-5">
            @foreach ($discussions as $discussion)
                <div class="bg-white hover:bg-gray-50 p-5 {{ config("discussions.styles.rounded") }}" wire:key="{{ $discussion->id }}">
                    <p class="mb-2 text-xl font-semibold">
                        <a href="{{ route('discussion', $discussion->slug) }}">{{ $discussion->title }}</a>
                    </p>
                    <p class="mb-2 text-gray-500">
                        {{ Str::limit($discussion->content, 50) }}
                    </p>
                    <p class="text-gray-500">
                        @lang('discussions::messages.discussion.posted_by') {{ $discussion->user->name }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>

    @auth
            <div x-data="{ open: false }"
                x-show="open"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="translate-y-full"
                x-transition:enter-end="translate-y-0"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="translate-y-0"
                x-transition:leave-end="translate-y-full"
                @discussion-new-open.window="open = true"
                class="fixed bottom-0 w-full max-w-3xl p-10 bg-white border border-b-0 border-gray-300 rounded-t" x-cloak>
                <input wire:model="title" type="text" placeholder="@lang('discussions::messages.editor.title')" class="w-full px-3 py-2 border {{ config("discussions.styles.rounded") }}">
                <textarea wire:model="content" placeholder="@lang('discussions::messages.editor.content')" class="w-full px-3 py-2 border {{ config("discussions.styles.rounded") }}"></textarea>
                <button wire:click="createDiscussion" class="px-4 py-2 mt-2 text-white bg-blue-500 {{ config("discussions.styles.rounded") }}">@lang('discussions::messages.words.create')</button>

                <div class="absolute top-0 right-0 pr-1">
                    <div @click="open = false" class="block p-3 cursor-pointer">&times;</div>
                </div>
            </div>
            
            @if (session()->has('message'))
                <div class="p-4 mb-4 text-white bg-green-500 {{ config("discussions.styles.rounded") }}">
                    {{ session('message') }}
                </div>
            @endif
        @endauth

</div>
