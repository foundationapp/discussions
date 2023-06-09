<?php

namespace Foundationapp\Discussions;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class DiscussionsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/Lang', 'discussions');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->publishes([
            __DIR__ . '/../public/assets' => public_path('vendor/foundationapp/discussions/assets'),
        ], 'discussions_assets');

        $this->publishes([
            __DIR__ . '/../config/discussions.php' => config_path('discussions.php'),
        ], 'discussions_config');

        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations'),
        ], 'discussions_migrations');

        $this->publishes([
            __DIR__ . '/../database/seeders/' => database_path('seeders'),
        ], 'discussions_seeders');

        $this->publishes([
            __DIR__ . '/Lang' => resource_path('lang/vendor/discussions'),
        ], 'discussions_lang');

        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');

        Livewire::component('discussion', \Foundationapp\Discussions\Components\Discussion::class);
        Livewire::component('discussions', \Foundationapp\Discussions\Components\Discussions::class);
        Livewire::component('posts', \Foundationapp\Discussions\Components\Posts::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadViewsFrom(__DIR__ . '/Views', 'discussions');
    }
}
