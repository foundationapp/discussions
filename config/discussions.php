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
