# Foundation Discussions Package

> Warning: This package is still in development and is not ready for use.

## Installation

This package assumes that you have created a [new Laravel application](https://laravel.com/docs/#your-first-laravel-project) and included the [TALL Stack preset](https://github.com/laravel-frontend-presets/tall) in your application. 

In this package we also make use of the [Filament Notifications package](https://filamentphp.com/docs/notifications/installation), which is used to show alert notifications.

![Notification Animated GIF](/assets/img/notification.gif)


To [install this package](https://filamentphp.com/docs/notifications/installation): we can do the following:

In the root directory of your app, run:

```
npm install alpinejs @awcodes/alpine-floating-ui postcss tailwindcss --save-dev
```

Then add to your main `app.js`

```
import AlpineFloatingUI from '@awcodes/alpine-floating-ui'
import NotificationsAlpinePlugin from '../../vendor/filament/notifications/dist/module.esm'

Alpine.plugin(AlpineFloatingUI)
Alpine.plugin(NotificationsAlpinePlugin)
```

Add the filament `'./vendor/filament/**/*.blade.php'` folder to your tailwind asset watcher under `content`:

> Additionally, extend some new colors in your tailwind.config.js theme 🎨

```
const colors = require('tailwindcss/colors')

module.exports = {
    content: [
        './resources/**/*.blade.php',
        './vendor/filament/**/*.blade.php', 
    ],
    theme: {
        extend: {
            colors: { 
                danger: colors.rose,
                primary: colors.blue,
                success: colors.green,
                warning: colors.yellow,
            }, 
        },
    },
}
```

Finally, add the following before the `</body>` tag in your `app.blade.php` file:

```
@livewire('notifications')
```

That's it. You're ready to start using the discussions package.

## 

## Events

The events are useful when you want to perform additional actions or trigger custom logic based on the creation of a new discussion or post like sending an email notification to the discussion participants.

| Event                                                       | Description                                       |
| ----------------------------------------------------------- | ------------------------------------------------- |
| `FoundationApp\Discussions\Events\NewDiscussionCreated`     | Dispatched when a new discussion is created.      |
| `FoundationApp\Discussions\Events\NewDiscussionPostCreated` | Dispatched when a new discussion post is created. |

#### Events Usage

The `event(new NewDiscussionCreated($discussion));` is dispatched after a new discussion is created. You can listen for this event in your application and perform any custom logic as needed. The same applies to the `NewDiscussionPostCreated` event which is dispatched after a new discussion post is created.

#### Creating a Listener for the `NewDiscussionCreated` Event

To create a listener to handle the `NewDiscussionCreated` event, follow these steps:

1. Create a Listener class
   Create a new class for your listener in the appropriate directory (e.g., `app/Listeners`). The class should implement the handle() method, which will receive the `NewDiscussionCreated` event as a parameter.

   ```php
   <?php
   namespace App\Listeners;

   use FoundationApp\Discussions\Events\NewDiscussionCreated;

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

   use FoundationApp\Discussions\Events\NewDiscussionCreated;
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
