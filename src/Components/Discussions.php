<?php

namespace FoundationApp\Discussions\Components;

use FoundationApp\Discussions\Models\Discussion;
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

    public function render()
    {
        $discussions = Discussion::paginate($this->loadMore);
        return view('discussions::discussions', ['discussions' => $discussions]);
    }

    public function createDiscussion()
    {
        Discussion::create([
            'title' => $this->title,
            'category_id' => $this->category_id,
            'content' => $this->content,
            'user_id' => auth()->user()->id,
        ]);

        $this->title = '';
        $this->content = '';

        session()->flash('message', 'Discussion created successfully.');
    }
}
