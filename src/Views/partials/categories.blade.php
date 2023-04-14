<div class="flex-shrink-0 mr-6 space-y-1 {{ config('discussions.styles.sidebar_width') }}">
    <h3 class="mb-2 font-bold">Categories</h3>

    <a href="/discussions" class="flex items-center px-3 py-2 font-medium space-x-2 text-sm @if(Request::is(config('discussions.home_route'))){{ 'bg-neutral-100 text-gray-800' }}@else{{ 'hover:bg-gray-100 text-gray-700 hover:text-gray-800' }}@endif {{ config('discussions.styles.rounded') }}">
        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" /></svg>
        <span>All Discussions</span>
    </a>
    <ul>
    @foreach(config('discussions.categories') as $index => $category)
        <li>
            <a href="/discussions/category/{{ $index }}" class="flex items-center px-3 py-2 font-medium space-x-2 text-sm hover:bg-gray-100 hover:text-gray-800 text-gray-700 {{ config('discussions.styles.rounded') }}">
                <span>{{ $category['icon'] }}</span>
                <span>{{ $category['title'] }}</span>
            </a>
        </li>
    @endforeach
    </ul>
</div>