<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'slug'];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($subcategory) {
            $subcategory->slug = Str::slug($subcategory->name);
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function ads()
    {
        return $this->hasMany(Ad::class);
    }
}
