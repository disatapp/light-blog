<?php

namespace Pavinbd\LightBlog;

use Illuminate\Database\Eloquent\Model;

class Taggable extends Model
{
    //
    protected $table = 'taggables';
    protected $fillable = [
        'id',
        'taggable_id',
        'tag_id',
        'taggable_type'
    ];

    public $timestamps = false;

}
