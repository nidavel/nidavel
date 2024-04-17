<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'featured_image',
        'post_type',
        'link',
        'keywords',
        'description',
        'user_id',
        'category_id'
    ];
}
