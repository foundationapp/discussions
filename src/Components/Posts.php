<?php

namespace Foundationapp\Discussions\Components;

use Foundationapp\Discussions\Models\Models;
use Livewire\Component;

class Posts extends Component
{

    public $discussion;
    public $editingPostId = null;
    public $editedContent;
    public $loadMore = 5;

    public $listeners = [
        'postAdded' => '$refresh',
    ];

    public function mount($discussion)
    {
        $this->discussion = $discussion;
    }

    public function loadMore()
    {
        $this->loadMore = $this->loadMore + 5;
    }

    public function delete($id)
    {
        if (auth()->user()->id != Models::post()->find($id)->user_id) {
            session()->flash('message', trans('discussions::alert.danger.reason.destroy_post'));
            return;
        }
        Models::post()->find($id)->delete();
    }

    public function edit($id)
    {
        if (auth()->user()->id != Models::post()->find($id)->user_id) {
            session()->flash('message', trans('discussions::alert.danger.reason.update_post'));
            return;
        }
        $this->editingPostId = $id;
        $this->editedContent = Models::post()->find($id)->content;
    }

    public function cancelEdit()
    {
        $this->editingPostId = null;
        $this->editedContent = null;
    }

    public function update($id)
    {
        $post = Models::post()->where('id', $id)->first();

        if (!$post) {
            return;
        }

        if (auth()->user()->id != $post->user_id) {
            session()->flash('message', trans('discussions::alert.danger.reason.update_post'));
            return;
        }

        $this->validate([
            'editedContent' => 'required',
        ]);

        $post->update([
            'content' => $this->editedContent,
        ]);

        $this->editingPostId = null;

        return;
    }

    public function render()
    {
        $posts = Models::post()->where('discussion_id', $this->discussion->id)->orderBy('created_at', 'asc')->paginate($this->loadMore);

        return view('discussions::livewire.posts', compact('posts'));
    }
}
