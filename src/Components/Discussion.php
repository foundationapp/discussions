<?php

namespace FoundationApp\Discussions\Components;

use FoundationApp\Discussions\Models\Models;
use Illuminate\Support\Str;
use Livewire\Component;

class Discussion extends Component
{
    public $title;
    public $slug;
    public $comment;
    public $discussion;
    public $category_id;
    public $editingPostId = null;
    public $editedContent;
    public $editingDiscussion = false;
    public $editingDiscussionTitle;
    public $editingDiscussionContent;
    public $loadMore = 5;

    public function mount($discussion)
    {
        $this->discussion = $discussion;
    }

    public function loadMore()
    {
        $this->loadMore = $this->loadMore + 5;
    }

    public function answer()
    {
        $this->validate([
            'comment' => 'required|min:6',
        ]);

        Models::post()->create([
            'content' => $this->comment,
            'discussion_id' => $this->discussion->id,
            'user_id' => auth()->user()->id,
        ]);

        $this->comment = '';

        session()->flash('message', 'Comment created successfully.');
    }

    public function delete($id)
    {
        if (auth()->user()->id != Models::post()->find($id)->user_id) {
            session()->flash('message', 'You are not the owner of this comment.');
            return;
        }
        Models::post()->find($id)->delete();
        session()->flash('message', 'Comment deleted successfully.');
    }

    public function edit($id)
    {
        if (auth()->user()->id != Models::post()->find($id)->user_id) {
            session()->flash('message', 'You are not the owner of this comment.');
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
        if (auth()->user()->id != Models::post()->find($id)->user_id) {
            session()->flash('message', 'You are not the owner of this comment.');
            return;
        }

        $post = Models::post()->find($id)->first();
        $post->update([
            'content' => $this->editedContent,
        ]);
        $this->editingPostId = null;
        return session()->flash('message', 'Comment updated successfully.');
    }

    public function deleteDiscussion()
    {
        if (auth()->user()->id != $this->discussion->user_id) {
            session()->flash('message', 'You are not the owner of this discussion.');
            return;
        }
        $this->discussion->delete();
        session()->flash('message', 'Discussion deleted successfully.');
        return redirect()->route('discussions.index');
    }

    public function editDiscussion()
    {
        if (auth()->user()->id != $this->discussion->user_id) {
            session()->flash('message', 'You are not the owner of this discussion.');
            return;
        }
        $this->editingDiscussion = true;
        $this->editingDiscussionTitle = $this->discussion->title;
        $this->editingDiscussionContent = $this->discussion->content;
    }

    public function updateDiscussion()
    {
        if (auth()->user()->id != $this->discussion->user_id) {
            session()->flash('message', 'You are not the owner of this discussion.');
            return;
        }
        $this->discussion->title = $this->editingDiscussionTitle;
        $this->discussion->content = $this->editingDiscussionContent;
        $this->discussion->save();

        $this->editingDiscussion = false;
    }

    public function cancelEditingDiscussion()
    {
        $this->editingDiscussion = false;
    }

    public function render()
    {
        $posts = Models::post()->with('user')->where('discussion_id', '=', $this->discussion->id)->orderBy('created_at', 'desc')->paginate(config('discussions.load_more.posts', 10));
        return view('discussions::livewire.discussion', compact('posts'));
    }
}
