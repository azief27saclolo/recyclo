<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
        'icon',
        'color'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = $category->slug ?? Str::slug($category->name);
        });

        static::updating(function ($category) {
            if ($category->isDirty('name') && !$category->isDirty('slug')) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * Get posts that belong to the category.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get active categories.
     */
    public static function getActive()
    {
        return self::where('is_active', true)->orderBy('name')->get();
    }

    /**
     * Scope a query to only include active categories.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Check if a category name exists among active categories (for validation).
     *
     * @param string $name
     * @return bool
     */
    public static function nameExistsInActive($name)
    {
        return self::where('name', $name)->where('is_active', true)->exists();
    }
}
