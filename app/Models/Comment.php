<?php

namespace App\Models;

use App\Helpers\FileHelper;
use App\Models\CommentFavorite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function images()
    {
        return $this->hasMany(CommentImage::class);
    }

    public function videos()
    {
        return $this->hasMany(CommentVideo::class);
    }

    public function recursiveChildren()
    {
        return $this->children()->with(['recursiveChildren', 'images', 'videos'])->withCount('favorites');
    }

    public function favorites()
    {
        return $this->hasMany(CommentFavorite::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($comment) {
            $comment->children()->each(function ($child) {
                $child->deleteAttachments($child);
                $child->delete();
            });
        });
    }

    public function deleteAttachments($child)
    {
        if ($child->images()->count() > 0) {
            foreach ($child->images as $filePath) {
                if (FileHelper::existsFile($filePath)) {
                    FileHelper::deleteFile($filePath);
                }
            }
        }
    }
}
