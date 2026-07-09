<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    protected $fillable = [
        'url', 'page_type', 'product_id', 'ip_address', 'user_agent', 'referer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
