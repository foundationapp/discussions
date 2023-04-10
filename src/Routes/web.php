<?php

use Illuminate\Support\Facades\Route;
use FoundationApp\Discussions\Controllers\DiscussionController;

Route::middleware(['web'])
    ->group(function () {
        Route::get(config('discussions.route_prefix', 'discussions'), \FoundationApp\Discussions\Components\Discussions::class)->name('discussions');
        Route::get(config('discussions.route_prefix_post', 'discussion') . '/{discussion_slug}', \FoundationApp\Discussions\Components\Discussion::class)->name('discussion');
    });
