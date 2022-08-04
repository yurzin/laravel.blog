<?php

namespace App\Models;

use App\Http\Requests\StorePostRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;
    use Sluggable;
    use SoftDeletes;

    protected $fillable = ['title', 'description', 'content', 'category_id', 'thumbnail'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function category()
    {
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

    /**
     * @param StorePostRequest $request
     * @param null $image
     * @return false|string|null
     */
    public static function uploadImage(StorePostRequest $request, $image = null)
    {
        if ($request->hasFile('thumbnail')) {
            if ($image) {
                Storage::delete($image);
            }
            $folder = date('Y-m-d');
            return $request->file('thumbnail')->storeAs("images/{$folder}", $request->file('thumbnail')->getClientOriginalName());
        }
        return null;
    }

    /**
     * @return string
     */
    public function getImageAttribute()
    {
        if (!$this->thumbnail) {
            return asset('noimage.img');
        }
        return asset("uploads/{$this->thumbnail}");
    }
}
