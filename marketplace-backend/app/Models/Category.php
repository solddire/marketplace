<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }
    
}
