<?php

namespace FeedMe\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class SubReddit extends Model
{

    protected $fillable = [
        'name',
        'title',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('withoutDefault', function (Builder $builder) {
            $builder->where('id', '!=', config('seeder.default.id'));
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function posts()
    {
        return $this->hasMany(SubRedditPost::class);
    }
}
