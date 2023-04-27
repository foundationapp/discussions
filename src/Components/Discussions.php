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
    public $sortOrder = 'desc';
    public $category_slug;
    public $category;
    public $loadMore = 5;

    public function mount($category = null)
    {
        $this->category = $category;
    }

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
            'slug' => $this->category_slug,
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

    public function updateSortOrder($order)
    {
        if ($order != 'asc' && $order != 'desc') {
            return;
        }
        $this->sortOrder = $order;
    }

    public function setCategory($slug)
    {
        if (!array_key_exists($slug, config('discussions.categories'))) {
            $this->category_slug = null;
        }
        $this->category_slug = $slug;
    }

    public function render()
    {
        
        $discussions = Discussion::query()
            ->where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('content', 'like', '%' . $this->search . '%');
            })
            ->when($this->category, function ($query) {
                return $query->where('category_slug', $this->category);
            })
            ->orderBy('created_at', $this->sortOrder)
            ->with('users')
            ->paginate($this->loadMore);

        $view = view('discussions::livewire.discussions', ['discussions' => $discussions]);

        $view->extends('layouts.app');

        return $view;
    }
}
