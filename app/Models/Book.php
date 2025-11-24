<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'seo_title',
        'seo_description',
        'image',
        'path',
        'price',
        'currency',
        'is_active',
        'is_featured',
        'is_new',
        'is_best_seller',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($book) {
            if (empty($book->slug)) {
                $book->slug = \Illuminate\Support\Str::slug($book->title);
            }
        });

        static::updating(function ($book) {
            // If title changed, update slug
            if ($book->isDirty('title') && empty($book->slug)) {
                $book->slug = \Illuminate\Support\Str::slug($book->title);
            }
        });
    }

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_new' => 'boolean',
        'is_best_seller' => 'boolean',
    ];

    protected $attributes = [
        'currency' => 'USD',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the book image URL or return a default placeholder
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            // If it's already a full URL (http/https), return it
            if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                return $this->image;
            }
            
            // If it's in public folder (e.g., "books/images/filename.jpg")
            if (strpos($this->image, 'books/images/') === 0 || strpos($this->image, '/books/images/') === 0) {
                $path = ltrim($this->image, '/');
                if (file_exists(public_path($path))) {
                    return asset($path);
                }
            }
            
            // If it's a storage path (legacy support)
            if (Storage::disk('public')->exists($this->image)) {
                return Storage::disk('public')->url($this->image);
            }
            
            // Try to construct URL from path if it doesn't start with http
            if (!preg_match('/^https?:\/\//', $this->image)) {
                // If it starts with storage/, add /storage/ prefix
                if (strpos($this->image, 'storage/') === 0) {
                    return asset('/' . $this->image);
                }
                // If it doesn't start with /, assume it's a public path
                if (strpos($this->image, '/') !== 0) {
                    return asset('/' . $this->image);
                }
                // If it starts with /, return as asset
                return asset($this->image);
            }
            
            return $this->image;
        }
        
        // Return a default placeholder image as SVG data URI
        return 'data:image/svg+xml,' . urlencode('<svg xmlns="http://www.w3.org/2000/svg" width="400" height="600"><rect fill="#6366f1" width="400" height="600"/><text fill="#fff" font-family="sans-serif" font-size="40" dy="10.5" font-weight="bold" x="50%" y="50%" text-anchor="middle">📖</text></svg>');
    }

    /**
     * Get the download URL for the book PDF
     */
    public function getDownloadUrlAttribute()
    {
        if ($this->path) {
            // If it's a storage path, return the full URL
            if (Storage::disk('public')->exists($this->path)) {
                return Storage::disk('public')->url($this->path);
            }
            // If it's already a URL, return it
            if (filter_var($this->path, FILTER_VALIDATE_URL)) {
                return $this->path;
            }
            // If it's a relative path, try to construct URL
            return asset($this->path);
        }
        return null;
    }
}

