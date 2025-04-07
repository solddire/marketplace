<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'category_id',
        'subcategory_id',
        'views_count',
        'favorites_count',
        'is_featured',
        'is_promoted',
        'last_viewed_at',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_slug', 'slug');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_slug', 'slug');
    }
}
