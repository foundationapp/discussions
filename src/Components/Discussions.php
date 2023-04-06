<?php

namespace FoundationApp\Discussions\Components;

use FoundationApp\Discussions\Models\Discussion;
use Illuminate\Support\Str;
use Livewire\Component;

class Discussions extends Component
{
    public $title;
    public $content;
    public $category_id;
    public $loadMore = 5;

    public function loadMore()
    {
        $this->loadMore = $this->loadMore + 5;
    }

    public function slugValidation($slug)
    {
        $slug = Str::slug($slug);
        $count = Discussion::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . $count;
        }
        return $slug;
    }

    public function createDiscussion()
    {
        $this->validate([
            'title' => 'required|min:6',
            'content' => 'required|min:6',
        ]);

        $slug = $this->slugValidation($this->title);

        Discussion::create([
            'title' => $this->title,
            'category_id' => $this->category_id,
            'content' => $this->content,
            'slug' => $slug,
            'user_id' => auth()->user()->id,
        ]);

        $this->title = '';
        $this->content = '';

        session()->flash('message', 'Discussion created successfully.');
    }

    public function render()
    {
        $discussions = Discussion::orderBy('created_at', 'desc')->with('users')->paginate($this->loadMore);
        return view('discussions::livewire.discussions', ['discussions' => $discussions]);
    }
}
