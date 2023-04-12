<div>
    <div class="mb-4 space-y-4">
        @if ($editing)
            <input type="text" class="w-full p-2 mb-2 text-gray-700 border rounded-lg focus:outline-none" wire:model="editingTitle">
            <textarea class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" rows="3" wire:model="editingContent"></textarea>
            <div class="flex justify-between mt-2">
                <button wire:click="updateDiscussion" class="px-4 py-2 text-white bg-green-500 rounded">@lang('discussions::messages.words.save')</button>
                <button wire:click="cancelEditing" class="px-4 py-2 text-white bg-gray-300 rounded">@lang('discussions::messages.words.cancel')</button>
            </div>
        @else
            <div class="relative space-y-2">
                <h1 class="text-4xl font-bold tracking-tighter">{{ $this->discussion->title }}</h1>
                <top-bar-discussion class="flex items-center justify-between w-full space-x-3 h-9">
                    <a href="{{ route('discussions') }}" class="relative inline-block w-auto text-sm font-medium opacity-50 cursor-pointer hover:opacity-100 group">
                        <span>&larr; back to all {{ strtolower(trans('discussions::intro.titles.discussions')) }}</span>
                        <span class="absolute bottom-0 left-0 w-0 h-px duration-200 ease-out bg-gray-900 group-hover:w-full"></span>
                    </a>
                    @auth
                        <div class="relative w-auto h-full">
                            <button-notifications onclick="window.livewire.emit('toggleNotification', {{ $this->discussion->id }})" class="flex items-center justify-between flex-shrink-0 h-full px-3 overflow-hidden text-sm font-medium border @if(!auth()->guest() && $this->discussion->users->contains(auth()->user()->id)){{ 'border-green-400 bg-green-50 text-green-600' }}@else{{ 'border-gray-300 bg-neutral-50 hover:bg-neutral-100' }}@endif cursor-pointer {{ config("discussions.styles.rounded") }}">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" /></svg>
                            </button-notifications>
                        </div>
                    @endauth
                </top-bar-discussion>
            </div>
           
            <div class="p-4 bg-neutral-100 {{ config("discussions.styles.rounded") }}">
                <div class="mb-2 text-gray-500">
                    {!! Str::markdown($this->discussion->content) !!}
                </div>
                <p class="text-gray-500">
                    @lang('discussions::messages.discussion.posted_by') {{ $this->discussion->user->name }}
                </p>
                @auth
                    <div class="flex justify-end mr-auto space-x-2 text-sm">
                        <button wire:click="deleteDiscussion" class="font-medium text-neutral-500 hover:text-orange-400 hover:underline">@lang('discussions::messages.words.report')</button>
                        @if (auth()->user()->id == $this->discussion->user_id)
                            <button wire:click="editDiscussion" class="font-medium text-neutral-500 hover:text-blue-500 hover:underline">@lang('discussions::messages.words.edit')</button>
                            <button wire:click="deleteDiscussion" class="font-medium text-neutral-500 hover:text-red-500 hover:underline">@lang('discussions::messages.words.delete')</button>
                        @endif
                    </div>
                @endauth
            </div>
        @endif
    </div>   


    @livewire('posts', ['discussion' => $this->discussion], key($this->discussion->id))

    <div class="mt-4 mb-4 space-y-4">
        @auth
            <div class="mb-4">
                <textarea wire:model="comment" placeholder="@lang('discussions::messages.editor.reply')" class="w-full px-3 py-2 border rounded"></textarea>
                <button wire:click="answer" class="px-4 py-2 mt-2 text-white bg-blue-500 rounded">@lang('discussions::messages.words.answer')</button>
            </div>
            
            @if (session()->has('message'))
                <div class="p-4 mb-4 text-white bg-green-500 rounded">
                    {{ session('message') }}
                </div>
            @endif
        @else
            <div class="p-4 mb-4 text-white bg-green-500 rounded">
                @lang('discussions::intro.please_login')
            </div>
        @endauth
    </div>

    
</div>
