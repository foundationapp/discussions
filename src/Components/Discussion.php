<?php

namespace FoundationApp\Discussions\Components;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Filament\Notifications\Notification; 
use FoundationApp\Discussions\Models\Models;
use FoundationApp\Discussions\Events\NewDiscussionPostCreated;

class Discussion extends Component
{
    public $title;
    public $slug;
    public $comment;
    public $discussion_slug;
    public $editing = false;
    public $editingTitle;
    public $editingContent;
    public $subscribers;

    public $rules = [
        'comment' => 'required|min:6'
    ];

    protected function getListeners()
    {
        return [
            'toggleNotification' => 'toggleNotification',
        ];
    }

    public function mount($discussion_slug)
    {
        $this->discussion_slug = $discussion_slug;
        $this->getSubscribers();
    }

    public function getDiscussionProperty()
    {
        return Models::discussion()->where('slug', $this->discussion_slug)->firstOrFail();
    }

    public function answer()
    {
        $validator = Validator::make($this->getDataForValidation($this->rules), $this->rules);
        
        if($validator->fails()) {

            Notification::make() 
                ->title('Validation error')
                ->danger()
                ->body( $validator->errors()->first() )
                ->send(); 
            return;
        }

        if ($this->checkTimeBetweenPosts() === false) {
            return;
        }

        $post = Models::post()->create([
            'content' => $this->comment,
            'discussion_id' => $this->discussion->id,
            'user_id' => auth()->user()->id,
        ]);

        event(new NewDiscussionPostCreated($post));

        if ($this->discussion->users->contains(auth()->user()->id) == false) {
            $this->discussion->users()->attach(auth()->user()->id);
        }

        $this->comment = '';

        $this->emit('postAdded');

        session()->flash('message', trans('discussions::alert.success.reason.submitted_to_post'));
    }

    public function checkTimeBetweenPosts()
    {
        if (config('discussions.security.limit_time_between_posts') === true) {
            $lastPost = Models::post()->where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->first();
            if ($lastPost != null) {
                $timeBetween = now()->diffInMinutes($lastPost->created_at);
                if ($timeBetween < config('discussions.security.time_between_posts')) {
                    session()->flash('message', trans('discussions::alert.danger.reason.prevent_spam'));
                    return false;
                }
            }
        }
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
        $this->getSubscribers();
        session()->flash('message', trans('discussions::alert.success.reason.subscribed_to_discussion'));
        return;
    }

    public function getSubscribers()
    {
        $this->subscribers = $this->discussion->users()->get();
    }

    public function render()
    {
        $view = view('discussions::livewire.discussion');

        $view->extends('layouts.app');

        return $view;
    }
}
