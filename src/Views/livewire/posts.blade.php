<div>
    <div class="mb-4 space-y-4">
        @foreach ($posts as $post)
            <div class="p-5 border border-neutral-200 @if(config("discussions.styles.rounded") == 'rounded-full'){{ 'rounded-xl' }}@else{{ config("discussions.styles.rounded") }}@endif">
                <div class="flex items-center mb-5 space-x-2">
                    <a href="{{ $post->user->profile_url }}" class="flex items-center space-x-2 text-sm font-bold group">
                        @include('discussions::partials.discussion-avatar', ['user' => $post->user, 'size' => 'sm'])
                        <span class="group group-hover:text-blue-500 group-hover:underline">{{ $post->user->name }}</span>
                    </a>
                    <p class="text-xs text-gray-500">on {{ $post->created_at->format('F jS, Y') }}</p>
                </div>
                
                @if(auth()->guest() || auth()->user() && $editingPostId !== $post->id )
                <discussion-post class="mb-2 prose-sm prose text-gray-500">
                    {!! Str::markdown($post->content) !!}
                </discussion-post>
                @endif

                @auth
                    @if ($editingPostId === $post->id)
                        <textarea wire:model="editedContent" class="w-full p-2 bg-gray-100 rounded"></textarea>
                        <div class="flex justify-end mt-2 space-x-2 text-sm">
                            <button wire:click="cancelEdit()" class="px-4 py-2 text-gray-500 bg-gray-100 rounded hover:bg-gray-200/60">@lang('discussions::messages.words.cancel')</button>
                            <button wire:click="update({{ $post->id }})" class="px-4 py-2 text-white bg-blue-500 rounded">@lang('discussions::messages.words.save')</button>
                        </div>
                    @else
                        <div class="flex justify-end mr-auto space-x-2 text-sm">
                            <button wire:click="deleteDiscussion" class="font-medium text-neutral-500 hover:text-orange-400 hover:underline">@lang('discussions::messages.words.report')</button>
                            @if (auth()->user()->id == $post->user_id)
                                <button wire:click="edit({{ $post->id }})" class="font-medium text-neutral-500 hover:text-blue-500 hover:underline">@lang('discussions::messages.words.edit')</button>
                                <button wire:click="delete({{ $post->id }})" class="font-medium text-neutral-500 hover:text-red-500 hover:underline">@lang('discussions::messages.words.delete')</button>
                            @endif
                        </div>
                    @endif
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
