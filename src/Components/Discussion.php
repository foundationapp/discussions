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
    public $editing = false;
    public $editingTitle;
    public $editingContent;

    protected function getListeners()
    {
        return [
            'toggleNotification' => 'toggleNotification',
        ];
    }


    public function mount($discussion)
    {
        $this->discussion = $discussion;
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

        if ($this->discussion->users->contains(auth()->user()->id) == false) {
            $this->discussion->users()->attach(auth()->user()->id);
        }

        $this->comment = '';

        $this->emit('postAdded');

        session()->flash('message', trans('discussions::alert.success.reason.submitted_to_post'));
    }

    public function deleteDiscussion()
    {
        if (auth()->user()->id != $this->discussion->user_id) {
            session()->flash('message', trans('discussions::alert.danger.reason.destroy_post'));
            return;
        }
        $this->discussion->delete();
        session()->flash('message', trans('discussions::alert.success.reason.destroy_post'));
        return redirect()->route('discussions.index');
    }

    public function editDiscussion()
    {
        if (auth()->user()->id != $this->discussion->user_id) {
            session()->flash('message', trans('discussions::alert.danger.reason.update_post'));
            return;
        }
        $this->editing = true;
        $this->editingTitle = $this->discussion->title;
        $this->editingContent = $this->discussion->content;
    }

    public function updateDiscussion()
    {
        if (auth()->user()->id != $this->discussion->user_id) {
            session()->flash('message', trans('discussions::alert.danger.reason.update_post'));
            return;
        }
        $this->discussion->title = $this->editingTitle;
        $this->discussion->content = $this->editingContent;
        $this->discussion->save();

        $this->editing = false;
    }

    public function cancelEditing()
    {
        $this->editing = false;
    }

    public function toggleNotification()
    {
        if ($this->discussion->users->contains(auth()->user()->id)) {
            $this->discussion->users()->detach(auth()->user()->id);
            session()->flash('message', trans('discussions::alert.success.reason.unsubscribed_from_discussion'));
            return;
        }
        $this->discussion->users()->attach(auth()->user()->id);
        session()->flash('message', trans('discussions::alert.success.reason.subscribed_to_discussion'));
        return;
    }

    public function render()
    {
        return view('discussions::livewire.discussion');
    }
}
