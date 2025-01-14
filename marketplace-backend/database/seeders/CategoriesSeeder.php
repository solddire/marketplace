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
                Subcategory::create([
                    'category_id' => $category->id,
                    'name' => $subcategoryName,
                    'slug' => \Str::slug($subcategoryName),
                ]);
            }
        }
    }
}
