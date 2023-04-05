<div>
    @auth
        <div class="mb-4">
            <input wire:model="title" type="text" placeholder="Enter discussion title" class="w-full px-3 py-2 border rounded">
            <textarea wire:model="content" placeholder="Enter discussion content" class="w-full px-3 py-2 border rounded"></textarea>
            <button wire:click="createDiscussion" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded">Create</button>
        </div>
        
        @if (session()->has('message'))
            <div class="p-4 bg-green-500 text-white mb-4 rounded">
                {{ session('message') }}
            </div>
        @endif
    @else
        <div class="p-4 bg-green-500 text-white mb-4 rounded">
            Please login to create a discussion
        </div>
    @endauth

    <div class="space-y-4">
        @foreach ($discussions as $discussion)
            <div class="p-4 bg-white shadow rounded">
                {{ $discussion->title }}
            </div>
        @endforeach
    </div>
</div>
