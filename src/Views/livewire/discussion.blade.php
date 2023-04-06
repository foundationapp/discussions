<div>
    <div class="space-y-4">
        @if ($editingDiscussion)
            <input type="text" class="w-full p-2 mb-2 text-gray-700 border rounded-lg focus:outline-none" wire:model="editingDiscussionTitle">
            <textarea class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" rows="3" wire:model="editingDiscussionContent"></textarea>
            <div class="flex justify-between mt-2">
                <button wire:click="updateDiscussion" class="px-4 py-2 bg-green-500 text-white rounded">Save</button>
                <button wire:click="cancelEditingDiscussion" class="px-4 py-2 bg-gray-300 text-white rounded">Cancel</button>
            </div>
        @else
            <h1 class="text-3xl font-semibold mb-6">{{ $discussion->title }}</h1>
            <div class="p-4 bg-white shadow rounded">
                <p class="text-gray-500 mb-2">
                    {{ $discussion->content }}
                </p>
                <p class="text-gray-500">
                    Posted by {{ $discussion->user->name }}
                </p>
                @auth
                    @if (auth()->user()->id == $discussion->user_id)
                        <button wire:click="editDiscussion" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded">Edit Discussion</button>
                        <button wire:click="deleteDiscussion" class="mt-2 px-4 py-2 bg-red-500 text-white rounded">Delete Discussion</button>
                    @endif
                @endauth
            </div>
        @endif
    </div>   

    <div class="space-y-4 mb-4 mt-4">
        @auth
            <div class="mb-4">
                <textarea wire:model="comment" placeholder="Enter discussion comment" class="w-full px-3 py-2 border rounded"></textarea>
                <button wire:click="answer" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded">Answer</button>
            </div>
            
            @if (session()->has('message'))
                <div class="p-4 bg-green-500 text-white mb-4 rounded">
                    {{ session('message') }}
                </div>
            @endif
        @else
            <div class="p-4 bg-green-500 text-white mb-4 rounded">
                Please login to comment on a discussion
            </div>
        @endauth
    </div>

    <div class="space-y-4 mb-4">
        @foreach ($posts as $post)
            <div class="p-4 bg-white shadow rounded" wire:key="{{ $post->id }}">
                @auth
                    @if ($editingPostId === $post->id)
                        {{-- Edit comment form --}}
                        <textarea wire:model="editedContent" class="w-full p-2 bg-gray-100 rounded"></textarea>
                        <div class="flex justify-between mt-2">
                            <button wire:click="update({{ $post->id }})" class="px-4 py-2 bg-blue-500 text-white rounded">Save</button>
                            <button wire:click="cancelEdit()" class="px-4 py-2 bg-gray-300 text-white rounded">Cancel</button>
                        </div>
                    @else
                        {{-- Display the comment content, the user name who posted it and a link to show the individual discussion --}}
                        <p class="text-gray-500 mb-2">
                            {{ $post->content }}
                        </p>
                        <p class="text-gray-500">
                            Posted by {{ $post->user->name }}
                        </p>
                        @if (auth()->user()->id == $post->user_id)
                            <div class="flex space-x-2 mt-2">
                                <button wire:click="edit({{ $post->id }})" class="px-4 py-2 bg-yellow-500 text-white rounded">Edit</button>
                                <button wire:click="delete({{ $post->id }})" class="px-4 py-2 bg-red-500 text-white rounded">Delete</button>
                            </div>
                        @endif
                    @endif
                @else
                    {{-- Display the comment content, the user name who posted it and a link to show the individual discussion --}}
                    <p class="text-gray-500 mb-2">
                        {{ $post->content }}
                    </p>
                    <p class="text-gray-500">
                        Posted by {{ $post->user->name }}
                    </p>
                @endauth
            </div>
        @endforeach
    </div>    
</div>
