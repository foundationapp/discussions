<div>
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
                            @lang('discussions::messages.discussion.posted_by'){{ $post->user->name }}
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
        @if ($posts->hasMorePages())
            <div class="flex justify-center">
                <button wire:click="loadMore" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                    @lang('discussions::messages.discussion.load_more')
                </button>
            </div>
        @endif
    </div>
</div>
