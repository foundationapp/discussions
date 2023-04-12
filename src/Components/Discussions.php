<?php

namespace FoundationApp\Discussions\Components;

use FoundationApp\Discussions\Events\NewDiscussionCreated;
use FoundationApp\Discussions\Models\Discussion;
use Illuminate\Support\Str;
use Livewire\Component;

class Discussions extends Component
{
    public $title;
    public $content;
    public $search;
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
            $slug = $slug . '-' . time();
        }
        return $slug;
    }

    public function createDiscussion()
    {
        $this->validate([
            'title' => 'required|min:6',
            'content' => 'required|min:6',
        ]);

        if ($this->checkTimeBetweenDiscussion() === false) {
            return;
        }

        $slug = $this->slugValidation($this->title);

        $discussion = Discussion::create([
            'title' => $this->title,
            'category_id' => $this->category_id,
            'content' => $this->content,
            'slug' => $slug,
            'user_id' => auth()->user()->id,
        ]);

        $this->title = '';
        $this->content = '';

        event(new NewDiscussionCreated($discussion));

        session()->flash('message', 'Discussion created successfully.');
    }

    public function checkTimeBetweenDiscussion()
    {
        if (config('discussions.security.limit_time_between_posts') === true) {
            $lastDiscussion = Discussion::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->first();
            if ($lastDiscussion != null) {
                $timeBetween = now()->diffInMinutes($lastDiscussion->created_at);
                if ($timeBetween < config('discussions.security.time_between_posts')) {
                    session()->flash('message', trans('discussions::alert.danger.reason.prevent_spam'));
                    return false;
                }
            }
        }
    }

    public function render()
    {
        $discussions = Discussion::where('title', 'like', '%' . $this->search . '%')
            ->orWhere('content', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->with('users')
            ->paginate($this->loadMore);
        $view = view('discussions::livewire.discussions', ['discussions' => $discussions]);

        $view->extends('layouts.app');

        return $view;
    }
}
