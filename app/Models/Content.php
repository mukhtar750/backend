<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $fillable = [
        'title',
        'type',
        'category_id',
        'visibility',
        'description',
        'tags',
        'file_path',
        'file_type',
        'file_size',
        'status',
        'user_id',
        'is_featured',
        'views',
        'downloads',
        'rating',
        'comments_count',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
