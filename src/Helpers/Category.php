<?php

namespace FoundationApp\Discussions\Helpers;


class Category
{
    public static function name($slug)
    {
        $name = '';
        if (array_key_exists($slug, config('discussions.categories'))) {
            if (isset(config('discussions.categories')[$slug]['icon'])) {
                $name .= config('discussions.categories')[$slug]['icon'] . ' ';
            }
            if (isset(config('discussions.categories')[$slug]['title'])) {
                $name .= config('discussions.categories')[$slug]['title'];
            }
        }
        return $name;
    }
}
