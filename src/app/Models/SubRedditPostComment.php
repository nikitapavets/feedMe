<?php

namespace FeedMe\Models;

use Illuminate\Database\Eloquent\Model;

class SubRedditPostComment extends Model
{
    protected $fillable = [
        'sub_reddit_post_id',
        'parent_id',
        'name',
        'message',
        'author',
        'permalink',
        'ups',
        'created_at',
    ];

    protected $hidden = [
        'sub_reddit_post_id',
        'parent_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function subRedditPost()
    {
        return $this->belongsTo(SubRedditPost::class, 'sub_reddit_post_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function parent()
    {
        return $this->belongsTo(SubRedditPostComment::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function children()
    {
        return $this->hasMany(SubRedditPostComment::class, 'parent_id');
    }
}
