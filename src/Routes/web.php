<?php

use Illuminate\Support\Facades\Route;
use Foundationapp\Discussions\Controllers\DiscussionController;

Route::middleware(['web'])
    ->group(function () {
        Route::get(config('discussions.route_prefix', 'discussions'), \Foundationapp\Discussions\Components\Discussions::class)->name('discussions');
        Route::get(config('discussions.route_prefix', 'discussions') . '/category/{category}', \Foundationapp\Discussions\Components\Discussions::class)->name('discussions.category');
        Route::get(config('discussions.route_prefix_post', 'discussion') . '/{discussion_slug}', \Foundationapp\Discussions\Components\Discussion::class)->name('discussion');
    });
