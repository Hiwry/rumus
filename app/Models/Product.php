<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'price', 'tag', 'category', 'type',
        'sizes', 'colors', 'rating', 'reviews_count',
        'description', 'bullets', 'specs', 'cares', 'images',
        'is_active', 'views_count',
    ];

    protected $casts = [
        'sizes'   => 'array',
        'colors'  => 'array',
        'bullets' => 'array',
        'specs'   => 'array',
        'cares'   => 'array',
        'images'  => 'array',
        'price'   => 'float',
        'is_active' => 'boolean',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function pageViews()
    {
        return $this->hasMany(PageView::class);
    }

    // Scope for active products
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Get formatted price
    public function getFormattedPriceAttribute(): string
    {
        return 'R$ ' . number_format($this->price, 2, ',', '.');
    }

    // Get primary image
    public function getPrimaryImageAttribute(): string
    {
        $images = $this->images ?? [];
        return !empty($images) ? $images[0] : 'images/sublimacao_mockup.png';
    }
}
