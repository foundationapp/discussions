# Foundation Discussions Package

> Warning: This package is still in development and is not ready for use.

## Events

The events are useful when you want to perform additional actions or trigger custom logic based on the creation of a new discussion or post like sending an email notification to the discussion participants.

| Event                                                       | Description                                       |
| ----------------------------------------------------------- | ------------------------------------------------- |
| `Foundationapp\Discussions\Events\NewDiscussionCreated`     | Dispatched when a new discussion is created.      |
| `Foundationapp\Discussions\Events\NewDiscussionPostCreated` | Dispatched when a new discussion post is created. |

#### Events Usage

The `event(new NewDiscussionCreated($discussion));` is dispatched after a new discussion is created. You can listen for this event in your application and perform any custom logic as needed. The same applies to the `NewDiscussionPostCreated` event which is dispatched after a new discussion post is created.

#### Creating a Listener for the `NewDiscussionCreated` Event

To create a listener to handle the `NewDiscussionCreated` event, follow these steps:

1. Create a Listener class
   Create a new class for your listener in the appropriate directory (e.g., `app/Listeners`). The class should implement the handle() method, which will receive the `NewDiscussionCreated` event as a parameter.

   ```php
   <?php
   namespace App\Listeners;

   use Foundationapp\Discussions\Events\NewDiscussionCreated;

   class CustomNewDiscussionListener
   {
       public function handle(NewDiscussionCreated $event)
       {
           // Your custom logic here
       }
   }
   ```

2. Implement your custom logic
   Inside the `handle()` method, you can access the discussion property of the event and perform any custom logic as needed.

   ```php
   public function handle(NewDiscussionCreated $event)
   {
       $discussion = $event->discussion;
       // Perform custom actions based on the new discussion
   }
   ```

3. Register the Listener
   To register the listener, add it to the listen property of the EventServiceProvider class located at `app/Providers/EventServiceProvider.php`.

   ```php
   protected $listen = [
       NewDiscussionCreated::class => [
           CustomNewDiscussionListener::class,
       ],
   ];
   ```

4. (Optional) Queue the Listener
   If you want your listener to be queued for asynchronous processing, you can implement the ShouldQueue interface and use the Queueable trait in your listener class.

   ```php
   <?php
   namespace App\Listeners;

   use Foundationapp\Discussions\Events\NewDiscussionCreated;
   use Illuminate\Contracts\Queue\ShouldQueue;
   use Illuminate\Queue\InteractsWithQueue;

   class CustomNewDiscussionListener implements ShouldQueue
   {
       use InteractsWithQueue;

       public function handle(NewDiscussionCreated $event)
       {
           // Your custom logic here
       }
   }
   ```
