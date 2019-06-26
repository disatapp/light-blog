<?php

namespace Disatapp\LightBlog;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //    
    protected $table = 'tags';
    protected $fillable = [
        'id',
        'tag_name',
        'tag_slug',
        'tag_description',
        'count',
    ];
    
    public function posts()
    {
        return $this->morphedByMany(Posts::class, 'taggable');
    }
}
