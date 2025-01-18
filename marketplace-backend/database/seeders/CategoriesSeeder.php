<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Category::truncate();
        Subcategory::truncate();

        $categories = [
            'Электроника' => ['Смартфоны', 'Ноутбуки', 'Телевизоры'],
            'Мебель' => ['Кровати', 'Диваны', 'Столы'],
            'Одежда' => ['Мужская', 'Женская', 'Детская'],
        ];

        foreach ($categories as $categoryName => $subcategories) {
            $category = Category::create([
                'name' => $categoryName,
                'slug' => \Str::slug($categoryName),
            ]);

            foreach ($subcategories as $subcategoryName) {
                $slug = \Str::slug($subcategoryName);
                $originalSlug = $slug;
                $counter = 1;
        
                while (Subcategory::where('slug', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
        
                Subcategory::create([
                    'category_id' => $category->id,
                    'name' => $subcategoryName,
                    'slug' => $slug,
                ]);
            }
        }
    }
}
