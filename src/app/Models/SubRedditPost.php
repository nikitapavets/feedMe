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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function subReddit()
    {
        return $this->belongsTo(SubReddit::class, 'sub_reddit_id');
    }
}
