<?php

namespace FeedMe\Models;

use Illuminate\Database\Eloquent\Model;

class SubRedditPost extends Model
{
    protected $fillable = [
        'name',
        'title',
        'author',
        'domain',
        'created_at',
    ];

    protected $hidden = [
        'sub_reddit_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function subReddit()
    {
        return $this->belongsTo(SubReddit::class, 'sub_reddit_id');
    }
}
