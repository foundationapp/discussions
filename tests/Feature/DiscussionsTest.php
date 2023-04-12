<?php

use function Pest\Livewire\livewire;

use FoundationApp\Discussions\Models\Discussion as DiscussionModel;
use FoundationApp\Discussions\Components\Discussion;
use FoundationApp\Discussions\Components\Discussions;

test('list_discussions', function () {
    livewire(Discussions::class)
        ->assertSee('Discussions')
        ->assertSee('Please')
        ->assertSee('New Discussion');
});

test('create_discussion', function () {

    $user = user();

    $this->actingAs($user);

    $asd = livewire(Discussions::class, ['user' => $user])
        ->set('title', 'Test first post')
        ->set('content', 'Test first post')
        ->call('createDiscussion')
        ->assertSee('Discussion created successfully.');
    $discussion = DiscussionModel::where('title', 'Test first post')->first();
    $this->assertNotNull($discussion);
});
