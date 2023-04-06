<div>
    <div class="space-y-4">
        @if ($editingDiscussion)
            <input type="text" class="w-full p-2 mb-2 text-gray-700 border rounded-lg focus:outline-none" wire:model="editingDiscussionTitle">
            <textarea class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" rows="3" wire:model="editingDiscussionContent"></textarea>
            <div class="flex justify-between mt-2">
                <button wire:click="updateDiscussion" class="px-4 py-2 bg-green-500 text-white rounded">@lang('discussions::messages.words.save')</button>
                <button wire:click="cancelEditingDiscussion" class="px-4 py-2 bg-gray-300 text-white rounded">@lang('discussions::messages.words.cancel')</button>
            </div>
        @else
            <h1 class="text-3xl font-semibold mb-6">{{ $discussion->title }}</h1>
            @auth
                <!-- Begin of Toggle Switch -->
                <div class="relative left-0 flex items-center justify-center mt-1 max-w-3xl mx-auto mb-4">
                    <!-- text to the right of toggle -->
                    <label for="toggleEmailSidebar" class="flex items-center cursor-pointer select-none">
                        <div class="mr-1.5 font-normal text-gray-500 dark:text-neutral-400 text-xxs">Notify me when this discussion gets a response</div>
                        <div class="relative">
                            <input id="toggleEmailSidebar" type="checkbox" @if(!auth()->guest() && $discussion->users->contains(auth()->user()->id)){{ 'checked' }}@endif onclick="window.livewire.emit('toggleNotification', {{ $discussion->id }})" class="hidden toggle__input">
                            <div class="w-12 h-6 px-2 bg-gray-400 rounded-full shadow-inner toggle__line dark:bg-dark-600">
                                <span class="absolute right-0 hidden mt-1 ml-2 text-xs font-medium leading-tight text-white yes dark:text-dark-100">YES</span>
                                <span class="absolute right-0 mt-1 mr-2 text-xs font-medium leading-tight text-gray-200 no">no</span>
                            </div>
                            <!-- dot -->
                            <div class="absolute inset-0 left-0 w-4 h-4 mt-1 ml-1 bg-white rounded-full shadow toggle__dot dark:bg-dark-800"></div>
                        </div>

                    </label>
                </div><!-- End of Toggle Switch -->
            @endauth
           
            <div class="p-4 bg-white shadow rounded">
                <p class="text-gray-500 mb-2">
                    {!! Str::markdown($discussion->content) !!}
                </p>
                <p class="text-gray-500">
                    @lang('discussions::messages.discussion.posted_by') {{ $discussion->user->name }}
                </p>
                @auth
                    @if (auth()->user()->id == $discussion->user_id)
                        <button wire:click="editDiscussion" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded">@lang('discussions::messages.words.edit')</button>
                        <button wire:click="deleteDiscussion" class="mt-2 px-4 py-2 bg-red-500 text-white rounded">@lang('discussions::messages.words.delete')</button>
                    @endif
                @endauth
            </div>
        @endif
    </div>   

    <div class="space-y-4 mb-4 mt-4">
        @auth
            <div class="mb-4">
                <textarea wire:model="comment" placeholder="@lang('discussions::messages.editor.reply')" class="w-full px-3 py-2 border rounded"></textarea>
                <button wire:click="answer" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded">@lang('discussions::messages.words.answer')</button>
            </div>
            
            @if (session()->has('message'))
                <div class="p-4 bg-green-500 text-white mb-4 rounded">
                    {{ session('message') }}
                </div>
            @endif
        @else
            <div class="p-4 bg-green-500 text-white mb-4 rounded">
                @lang('discussions::intro.please_login')
            </div>
        @endauth
    </div>

    <div class="space-y-4 mb-4">
        @foreach ($posts as $post)
            <div class="p-4 bg-white shadow rounded" wire:key="{{ $post->id }}">
                @auth
                    @if ($editingPostId === $post->id)
                        <textarea wire:model="editedContent" class="w-full p-2 bg-gray-100 rounded"></textarea>
                        <div class="flex justify-between mt-2">
                            <button wire:click="update({{ $post->id }})" class="px-4 py-2 bg-blue-500 text-white rounded">@lang('discussions::messages.words.save')</button>
                            <button wire:click="cancelEdit()" class="px-4 py-2 bg-gray-300 text-white rounded">@lang('discussions::messages.words.cancel')</button>
                        </div>
                    @else
                        <p class="text-gray-500 mb-2">
                            {!! Str::markdown($post->content) !!}
                        </p>
                        <p class="text-gray-500">
                            Posted by {{ $post->user->name }}
                        </p>
                        @if (auth()->user()->id == $post->user_id)
                            <div class="flex space-x-2 mt-2">
                                <button wire:click="edit({{ $post->id }})" class="px-4 py-2 bg-yellow-500 text-white rounded">@lang('discussions::messages.words.edit')</button>
                                <button wire:click="delete({{ $post->id }})" class="px-4 py-2 bg-red-500 text-white rounded">@lang('discussions::messages.words.delete')</button>
                            </div>
                        @endif
                    @endif
                @else
                    <p class="text-gray-500 mb-2">
                        {!! Str::markdown($post->content) !!}
                    </p>
                    <p class="text-gray-500">
                        @lang('discussions::messages.discussion.posted_by') {{ $post->user->name }}
                    </p>
                @endauth
            </div>
        @endforeach
    </div>    
</div>
