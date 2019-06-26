<?php

namespace Pavinbd\LightBlog;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    protected $table = 'posts';
    protected $fillable = [
        'id',
        'user_id',
        'title',
        'content',
        'slug',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo('Pavinbd\LightBlog\User');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    protected $casts = [
        
    ];

}
