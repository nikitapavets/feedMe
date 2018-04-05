<?php

namespace FeedMe\Models;

use Illuminate\Database\Eloquent\Model;

class SubReddit extends Model
{
    protected $fillable = [
        'name',
        'title',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function posts()
    {
        return $this->hasMany(SubRedditPost::class);
    }
}
