<?php

namespace Disatapp\LightBlog;

use Illuminate\Database\Eloquent\Model;

class Photos extends Model
{
    //
    protected $table = 'photos';
    protected $fillable = [
        'name',
        'slug',
        'permission',
        'description'
    ];
}
