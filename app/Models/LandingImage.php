<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LandingImage extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'title', 'path', 'section'];

    /**
     * Get the full URL of the asset image
     */
    public function getUrlAttribute(): string
    {
        // If path starts with http or https, return it as is, otherwise return asset URL
        if (preg_match('/^https?:\/\//', $this->path)) {
            return $this->path;
        }
        return asset($this->path);
    }
}
