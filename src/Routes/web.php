<?php

use Illuminate\Support\Facades\Route;
use FoundationApp\Discussions\Controllers\DiscussionController;

Route::middleware(['web'])
    ->prefix(config('discussions.route_prefix', 'discussions'))
    ->group(function () {
        Route::get('/', [DiscussionController::class, 'index'])->name('discussions.index');
        Route::get('/{discussion}', [DiscussionController::class, 'show'])->name('discussions.show');
    });
