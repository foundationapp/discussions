<div>
    <div class="space-y-4">
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
                <a href="{{ route('discussions') }}" class="relative inline-block w-auto text-sm font-medium opacity-50 cursor-pointer hover:opacity-100 group">
                    <span>&larr; back to all {{ strtolower(trans('discussions::intro.titles.discussions')) }}</span>
                    <span class="absolute bottom-0 left-0 w-0 h-px duration-200 ease-out bg-gray-900 group-hover:w-full"></span>
                </a>
            </div>
            @auth
                <!-- Begin of Toggle Switch -->
                <div class="relative left-0 flex items-center justify-center hidden max-w-3xl mx-auto mt-1 mb-4">
                    <!-- text to the right of toggle -->
                    <label for="toggleEmailSidebar" class="flex items-center cursor-pointer select-none">
                        <div class="mr-1.5 font-normal text-gray-500 dark:text-neutral-400 text-xxs">Notify me when this discussion gets a response</div>
                        <div class="relative">
                            <input id="toggleEmailSidebar" type="checkbox" @if(!auth()->guest() && $this->discussion->users->contains(auth()->user()->id)){{ 'checked' }}@endif onclick="window.livewire.emit('toggleNotification', {{ $this->discussion->id }})" class="hidden toggle__input">
                            <div class="w-12 h-6 px-2 bg-gray-400 rounded-full shadow-inner toggle__line dark:bg-dark-600">
                                <span class="absolute right-0 hidden mt-1 ml-2 text-xs font-medium leading-tight text-white yes dark:text-dark-100">YES</span>
                                <span class="absolute right-0 mt-1 mr-2 text-xs font-medium leading-tight text-gray-200 no">no</span>
                            </div>
                            <div class="absolute inset-0 left-0 w-4 h-4 mt-1 ml-1 bg-white rounded-full shadow toggle__dot dark:bg-dark-800"></div>
                        </div>

                    </label>
                </div><!-- End of Toggle Switch -->
                
            @endauth
           
            <div class="p-4 bg-white rounded shadow">
                <p class="mb-2 text-gray-500">
                    {!! Str::markdown($this->discussion->content) !!}
                </p>
                <p class="text-gray-500">
                    @lang('discussions::messages.discussion.posted_by') {{ $this->discussion->user->name }}
                </p>
                @auth
                    @if (auth()->user()->id == $this->discussion->user_id)
                        <button wire:click="editDiscussion" class="px-4 py-2 mt-2 text-white bg-blue-500 rounded">@lang('discussions::messages.words.edit')</button>
                        <button wire:click="deleteDiscussion" class="px-4 py-2 mt-2 text-white bg-red-500 rounded">@lang('discussions::messages.words.delete')</button>
                    @endif
                @endauth
            </div>
        @endif
    </div>   

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

    @livewire('posts', ['discussion' => $this->discussion], key($this->discussion->id))
</div>
