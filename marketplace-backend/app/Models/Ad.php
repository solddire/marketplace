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
