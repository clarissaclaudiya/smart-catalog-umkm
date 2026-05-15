<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Categories
        $cats = [
            ['name' => 'Pakaian', 'slug' => 'pakaian', 'description' => 'Koleksi busana modern dan nyaman.'],
            ['name' => 'Alat Dapur', 'slug' => 'alat-dapur', 'description' => 'Peralatan masak berkualitas tinggi.'],
            ['name' => 'Sepatu', 'slug' => 'sepatu', 'description' => 'Alas kaki trendy untuk segala suasana.'],
        ];

        foreach ($cats as $cat) {
            $category = Category::create($cat);

            // 2. Create 3 Products for each category
            for ($i = 1; $i <= 3; $i++) {
                Product::create([
                    'category_id' => $category->id,
                    'name' => $category->name . ' - Model ' . $i,
                    'price' => rand(50000, 200000),
                    'stock' => 10, // Stok Admin diperkecil jadi 10
                    'image' => 'placeholder.png',
                ]);
            }
        }
    }
}
