<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'post';

    protected $fillable = [
        'title', 'body', 'author', 'author_id', 'tag', 'category','post_link','image'
    ];
    
}
