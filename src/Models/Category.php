<?php

namespace FoundationApp\Discussions\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'discussion_categories';
    public $timestamps = true;
    public $with = 'parents';

    public function discussions()
    {
        return $this->hasMany(Models::className(Discussion::class), 'discussion_category_id');
    }

    public function parents()
    {
        return $this->hasMany(Models::classname(self::class), 'parent_id')->orderBy('order', 'asc');
    }
}
