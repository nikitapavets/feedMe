<?php

namespace FeedMe\Models;

use Illuminate\Database\Eloquent\Model;

class SubRedditPost extends Model
{
    protected $fillable = [
        'name',
        'title',
        'description',
        'author',
        'domain',
        'url',
        'ups',
        'permalink',
        'created_at',
    ];

    protected $hidden = [
        'sub_reddit_id',
        'comments_grid',
        'comments',
    ];

    protected $appends = [
        'comments_count',
        'comments_grid'
    ];

    /**
     * @return mixed
     */
    public function getCommentsCountAttribute()
    {
        return $this->comments()->count();
    }

    /**
     * @return array
     */
    public function getCommentsGridAttribute()
    {
        return $this->getCommentsGrid($this->comments, config('seeder.default.id'));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function subReddit()
    {
        return $this->belongsTo(SubReddit::class, 'sub_reddit_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function comments()
    {
        return $this->hasMany(SubRedditPostComment::class, 'sub_reddit_post_id');
    }

    /**
     * @param $comments
     * @param $rootId
     * @return array
     */
    public function getCommentsGrid($comments, $rootId)
    {
        $gridRootBranch = [];

        foreach ($comments as $comment) {
            if ($this->isRootComment($comment, $rootId)) {
                $gridRootNode = $comment;
                $gridNode['children'] = $this->getCommentsGrid($comment->children, $comment->id);
                $gridRootBranch[] = $gridRootNode;
            }
        }

        return $gridRootBranch;
    }

    /**
     * @param $comment
     * @param $rootId
     * @return bool
     */
    public function isRootComment($comment, $rootId)
    {
        return $comment->parent_id === (int)$rootId;
    }
}
