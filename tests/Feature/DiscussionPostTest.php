<?php

use function Pest\Livewire\livewire;

use Foundationapp\Discussions\Models\Discussion as DiscussionModel;
use Foundationapp\Discussions\Components\Discussion;
use Foundationapp\Discussions\Components\Discussions;
use Foundationapp\Discussions\Components\Posts;

test('list_and_create_discussion_posts', function () {
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

test('edit_delete_discussion_posts', function () {
    $user = user('test1');

    $this->actingAs($user);

    livewire(Discussions::class, ['user' => $user])
        ->set('title', 'Test first post')
        ->set('content', 'Test first post')
        ->call('createDiscussion')
        ->assertSee('Discussion created successfully.');
    $discussion = DiscussionModel::where('title', 'Test first post')->first();

    livewire(Discussion::class, ['discussion_slug' => $discussion->slug])
        ->assertSee('Test first post')
        ->assertSee('Test first post');

    livewire(Discussion::class, ['discussion_slug' => $discussion->slug])
        ->set('comment', 'Test first post answer')
        ->call('answer');

    livewire(Discussion::class, ['discussion_slug' => $discussion->slug])
        ->set('comment', 'Test first post answer 2')
        ->call('answer');

    $answer = $discussion->posts()->where('content', 'Test first post answer')->first();

    livewire(Posts::class, ['discussion' => $discussion])
        ->assertSee('Test first post answer')
        ->assertSee('Test first post');

    // edit the post
    livewire(Posts::class, ['discussion' => $discussion])
        ->call('edit', $answer->id)
        ->set('editedContent', 'Test first post answer edited')
        ->call('update', $answer->id)
        ->assertSee('Test first post answer edited')
        ->assertSee('Test first post');

    // delete the post
    livewire(Posts::class, ['discussion' => $discussion])
        ->call('delete', $answer->id)
        ->assertDontSee('Test first post answer edited')
        ->assertSee('Test first post');
});

test('edit_delete_posts_as_another_user', function () {

    $user = user('test1');

    $this->actingAs($user);

    livewire(Discussions::class, ['user' => $user])
        ->set('title', 'Test first post')
        ->set('content', 'Test first post')
        ->call('createDiscussion')
        ->assertSee('Discussion created successfully.');
    $discussion = DiscussionModel::where('title', 'Test first post')->first();
    livewire(Discussion::class, ['discussion_slug' => $discussion->slug])
        ->set('comment', 'Test first post answer')
        ->call('answer');

    $answer = $discussion->posts()->where('content', 'Test first post answer')->first();

    $user2 = user('test2');

    $this->actingAs($user2);

    livewire(Posts::class, ['discussion' => $discussion])
        ->call('edit', $answer->id)
        ->set('editedContent', 'Test first post answer edited')
        ->call('update', $answer->id)
        ->assertSee('Test first post answer')
        ->assertDontSee('Test first post answer edited');

    livewire(Posts::class, ['discussion' => $discussion])
        ->call('delete', $answer->id)
        ->assertSee('Test first post answer');
});

// Test the toggleNotification method on the Discussion component
test('toggle_notification', function () {
    $user = user('test1');

    $this->actingAs($user);

    livewire(Discussions::class, ['user' => $user])
        ->set('title', 'Test first post')
        ->set('content', 'Test first post')
        ->call('createDiscussion')
        ->assertSee('Discussion created successfully.');
    $discussion = DiscussionModel::where('title', 'Test first post')->first();

    livewire(Discussion::class, ['discussion_slug' => $discussion->slug])
        ->assertSee('Test first post')
        ->assertSee('Test first post');

    livewire(Discussion::class, ['discussion_slug' => $discussion->slug])
        ->call('toggleNotification')
        ->assertSee('You will now receive notifications for this discussion.');

    livewire(Discussion::class, ['discussion_slug' => $discussion->slug])
        ->call('toggleNotification')
        ->assertSee('You will no longer recieve notifications for this discussion.');
});
