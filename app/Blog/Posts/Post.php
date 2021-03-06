<?php

namespace App\Blog\Posts;

use App\Blog\BaseApp\BaseModel;
use App\Blog\Categories\Category;
use App\Blog\Tags\Tag;
use App\Blog\users\User;
use App\Http\Controllers\Comments\Comment;

class Post extends BaseModel
{
    protected $table = 'posts';
    public $timestamps = true;
    protected $fillable = [
        'title',
        'description',
        'category_id',
        'category_title',
        'postimg',
        'author_id',
        'is_active',

    ];

    public function getData()
    {
        return $this;
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id');
    }

    public function getCategories()
    {
        return Category::with('title')->pluck('title', 'id')->toArray();

    }

    public function getTags()
    {
        return Tag::with('title')->pluck('title', 'id')->toArray();

    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function getAuthors()
    {
        return User::with('name')->pluck('name', 'id')->toArray();

    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}
