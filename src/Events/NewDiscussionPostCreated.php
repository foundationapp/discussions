<?php

namespace Foundationapp\Discussions\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewDiscussionPostCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $post;

    public function __construct($post)
    {
        $this->post = $post;
    }
}
