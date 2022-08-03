<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use Sluggable;
    use SoftDeletes;

    protected $fillable = ['title', 'description', 'content', 'category_id', 'thumbnail'];

    public function tags() {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return array|string[]
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
