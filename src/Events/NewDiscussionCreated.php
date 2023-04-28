<?php

namespace Foundationapp\Discussions\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewDiscussionCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $discussion;

    public function __construct($discussion)
    {
        $this->discussion = $discussion;
    }
}
