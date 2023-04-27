<?php

namespace FoundationApp\Discussions\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discussion extends Model
{
    use SoftDeletes;

    protected $table = 'discussions';
    public $timestamps = true;
    protected $fillable = ['title', 'content', 'category_slug', 'user_id', 'slug', 'color'];
    protected $dates = ['deleted_at', 'last_reply_at'];

    public function user()
    {
        return $this->belongsTo(config('discussions.user.namespace'));
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
        return $this->belongsToMany(config('discussions.user.namespace'), 'discussion_post_users', 'user_id', 'id');
    }

    public function avatar()
    {
        return $this->belongsTo(Models::className(Avatar::class), 'avatar_id');
    }
}
