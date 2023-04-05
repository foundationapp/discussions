<?php

namespace FoundationApp\Discussions\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discussion extends Model
{
    use SoftDeletes;

    protected $table = 'discussions';
    public $timestamps = true;
    protected $fillable = ['title', 'content', 'category_id', 'user_id', 'slug', 'color'];
    protected $dates = ['deleted_at', 'last_reply_at'];

    public function user()
    {
        return $this->belongsTo(config('discussion.user.namespace'));
    }

    public function category()
    {
        return $this->belongsTo(Models::className(Category::class), 'category_id');
    }

    public function posts()
    {
        return $this->hasMany(Models::className(Post::class), 'discussion_id');
    }

    public function post()
    {
        return $this->hasMany(Models::className(Post::class), 'discussion_id')->orderBy('created_at', 'ASC');
    }

    public function postsCount()
    {
        return $this->posts()
            ->selectRaw('discussion_id, count(*)-1 as total')
            ->groupBy('discussion_id');
    }

    public function users()
    {
        return $this->belongsToMany(config('discussion.user.namespace'), 'discussion_user', 'discussion_id', 'user_id');
    }
}
