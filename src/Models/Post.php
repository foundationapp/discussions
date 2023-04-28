<?php

namespace Foundationapp\Discussions\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $table = 'discussion_posts';
    public $timestamps = true;
    protected $fillable = ['discussion_id', 'user_id', 'content'];
    protected $dates = ['deleted_at'];

    public function discussion()
    {
        return $this->belongsTo(Models::className(Discussion::class), 'discussion_id');
    }

    public function user()
    {
        return $this->belongsTo(config('discussions.user.namespace'));
    }
}
