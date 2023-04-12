<?php

return [
    'headline_logo' => '/vendor/foundationapp/discussions/assets/images/logo-light.png',

    'user' => [
        'namespace'                     => 'App\Models\User',
        'database_field_with_user_name' => 'name',
        'relative_url_to_profile'       => '',
        'relative_url_to_image_assets'  => '',
        'avatar_image_database_field'   => '',
    ],

    'load_more' => [
        'posts' => 10,
        'discussions' => 10,
    ],

    'home_route' => 'discussions',
    'route_prefix' => 'discussions',

    /*
    |--------------------------------------------------------------------------
    | A Few security measures to prevent spam on your forum
    |--------------------------------------------------------------------------
    |
    | Here are a few configurations that you can add to your forum to prevent
    | possible spammers or bots.
    |
    |   *limit_time_between_posts*: Stop user from being able to spam by making
    |       them wait a specified time before being able to post again.
    |
    |   *time_between_posts*: In minutes, the time a user must wait before
    |       being allowed to add more content. Only valid if above value is
    |       set to true.
    |
    */

    'security' => [
        'limit_time_between_posts' => true, // true or false
        'time_between_posts'       => 1, // In minutes
    ],

    /*
    |--------------------------------------------------------------------------
    | Editor
    |--------------------------------------------------------------------------
    |
    | You may wish to choose between a couple different editors. At the moment
    | The following editors are supported:
    |   - tinymce    (https://www.tinymce.com/)
    |
    */

    'editor' => 'textarea',
];
