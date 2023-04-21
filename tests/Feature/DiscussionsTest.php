<?php

use function Pest\Livewire\livewire;

use Foundationapp\Discussions\Models\Discussion as DiscussionModel;
use Foundationapp\Discussions\Components\Discussion;
use Foundationapp\Discussions\Components\Discussions;

test('list_discussions', function () {
    livewire(Discussions::class)
        ->assertSee('Discussions')
        ->assertSee('Please')
        ->assertSee('New Discussion');
});

test('create_discussion', function () {
    $user = user('test1');

    $this->actingAs($user);

    livewire(Discussions::class, ['user' => $user])
        ->set('title', 'Test first post')
        ->set('content', 'Test first post')
        ->call('createDiscussion')
        ->assertSee('Discussion created successfully.');
    $discussion = DiscussionModel::where('title', 'Test first post')->first();
    $this->assertNotNull($discussion);
});

test('edit_discussion', function () {
    $user = user('test1');

    $this->actingAs($user);

    livewire(Discussions::class, ['user' => $user])
        ->set('title', 'Test first post')
        ->set('content', 'Test first post')
        ->call('createDiscussion');
    $discussion = DiscussionModel::where('title', 'Test first post')->first();

    livewire(Discussion::class, ['discussion_slug' => $discussion->slug])
        ->assertSee('Test first post')
        ->assertSee('Test first post')
        ->set('editingTitle', 'Test first post edited')
        ->set('editingContent', 'Test first post edited')
        ->call('updateDiscussion');
    $discussion = DiscussionModel::where('title', 'Test first post edited')->first();
    $this->assertNotNull($discussion);
});

test('prevent_editing_discussion_by_wrong_user', function () {
    $user1 = user('test1');
    $user2 = user('test2');

    $this->actingAs($user1);

    livewire(Discussions::class, ['user' => $user1])
        ->set('title', 'Test first post')
        ->set('content', 'Test first post')
        ->call('createDiscussion');

    $discussion = DiscussionModel::where('title', 'Test first post')->first();

    $this->actingAs($user2);
    livewire(Discussion::class, ['discussion_slug' => $discussion->slug])
        ->assertSee('Test first post')
        ->assertSee('Test first post')
        ->set('editingTitle', 'Test first post by user 2')
        ->set('editingContent', 'Test first post by user 2')
        ->call('updateDiscussion');
    $discussionEdited = DiscussionModel::where('title', 'Test first post by user 2')->first();
    $this->assertNull($discussionEdited);
});

test('prevent_deleting_discussion_by_wrong_user', function () {
    $user1 = user('test1');
    $user2 = user('test2');

    $this->actingAs($user1);

    livewire(Discussions::class, ['user' => $user1])
        ->set('title', 'Test first post')
        ->set('content', 'Test first post')
        ->call('createDiscussion');

    $discussion = DiscussionModel::where('title', 'Test first post')->first();

    $this->actingAs($user2);
    livewire(Discussion::class, ['discussion_slug' => $discussion->slug])
        ->assertSee('Test first post')
        ->assertSee('Test first post')
        ->call('deleteDiscussion');
    $discussion = DiscussionModel::where('title', 'Test first post')->first();
    $this->assertNotNull($discussion);
});
