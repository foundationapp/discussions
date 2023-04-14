<div class="relative mx-auto {{ config('discussions.styles.container_max_width') }}">
    <discussion-content-top>
        <div class="relative mb-5 space-y-2">
            <h1 class="text-4xl font-bold tracking-tighter">{{ $this->discussion->title }}</h1>
            <div class="flex items-center justify-between w-full h-auto">
                <a href="{{ route('discussions') }}" class="relative inline-block w-auto text-sm font-medium opacity-50 cursor-pointer hover:opacity-100 group">
                    <span>&larr; back to all {{ strtolower(trans('discussions::intro.titles.discussions')) }}</span>
                    <span class="absolute bottom-0 left-0 w-0 h-px duration-200 ease-out bg-gray-900 group-hover:w-full"></span>
                </a>
            </div>
            @include('discussions::partials.guest-auth-message')
            @if (session()->has('message'))
                <div class="p-4 mb-4 text-white bg-green-500 rounded">
                    {{ session('message') }}
                </div>
            @endif
        </div>
    </discussion-content-top>
    <div class="flex items-start w-full">
        

        <discussion-content-left class="relative w-full">
            <div class="mb-4 space-y-4">
                @if ($editing)
                    <input type="text" class="w-full p-2 mb-2 text-gray-700 border rounded-lg focus:outline-none" wire:model="editingTitle">
                    <textarea class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" rows="3" wire:model="editingContent"></textarea>
                    <div class="flex justify-between mt-2">
                        <button wire:click="updateDiscussion" class="px-4 py-2 text-white bg-green-500 rounded">@lang('discussions::messages.words.save')</button>
                        <button wire:click="cancelEditing" class="px-4 py-2 text-white bg-gray-300 rounded">@lang('discussions::messages.words.cancel')</button>
                    </div>
                @else
                
                    <div class="py-4 px-5 border border-neutral-200 @if(config("discussions.styles.rounded") == 'rounded-full'){{ 'rounded-xl' }}@else{{ config("discussions.styles.rounded") }}@endif">
                        <div class="flex items-center mb-3 space-x-2">
                            <a href="{{ $this->discussion->user->profile_url }}" class="flex items-center space-x-2 text-sm font-bold group">
                                @include('discussions::partials.discussion-avatar', ['user' => $this->discussion->user])
                                <span class="group group-hover:text-blue-500 group-hover:underline">{{ $this->discussion->user->name }}</span>
                            </a>
                            <p class="text-xs text-gray-500">on {{ $this->discussion->created_at->format('F jS, Y') }}</p>
                        </div>
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
                @endif
            </div>
        </discussion-content-left>
    
        <discussion-content-right class="{{ config('discussions.styles.sidebar_width') }} flex-shrink-0 text-sm ml-8">
            <h3 class="font-semibold text-neutral-500">Categories</h3>
            <p class="my-2 text-xs opacity-60">show category</p>
            <hr />
            <h3 class="mt-5 font-semibold text-neutral-500">Participants</h3>
            <p class="my-2 text-xs opacity-60">show participants</p>
            <hr />
            @auth
                <h3 class="mt-5 font-semibold text-neutral-500">Notifications</h3>
                <div class="relative w-auto h-full my-2">
                    <button-notifications onclick="window.livewire.emit('toggleNotification', {{ $this->discussion->id }})" class="flex items-center justify-center flex-shrink-0 h-full px-3 py-1 overflow-hidden text-sm space-x-1 font-medium border @if($this->discussion->users->contains(auth()->user()->id)){{ 'border-green-400 bg-green-50 text-green-600' }}@else{{ 'border-gray-300 bg-neutral-50 hover:bg-neutral-100' }}@endif cursor-pointer {{ config("discussions.styles.rounded") }}">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" /></svg>
                        <span>Subscribe</span>
                    </button-notifications>
                </div>
                @if($this->discussion->users->contains(auth()->user()->id))
                    <p>You're receiving notifications because you're subscribed to this thread.</p>
                @else
                    <p>You are not recieving notifications about this discussion</p>
                @endif
            @endauth
        </discussion-content-right>

    </div>

    
</div>
