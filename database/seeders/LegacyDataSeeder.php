<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LegacyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Copy Users (Skipped)

        // 2. Copy Categories
        DB::table('categories')->delete();
        $oldCategories = DB::table('old_categories')->get();
        foreach ($oldCategories as $cat) {
            DB::table('categories')->insert([
                'id' => $cat->id,
                'category_name' => $cat->category_name,
                'slug' => $cat->slug,
                'description' => $cat->description,
                'image' => $cat->image,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3. Copy Products
        DB::table('products')->delete();
        $oldProducts = DB::table('old_products')->get();
        foreach ($oldProducts as $prod) {
            DB::table('products')->insert([
                'id' => $prod->id,
                'category_id' => $prod->category_id,
                'name' => $prod->name,
                'description' => $prod->description,
                'price' => $prod->price,
                'old_price' => $prod->old_price,
                'image' => $prod->image,
                'brand' => $prod->brand,
                'quantity' => $prod->quantity,
                'discount' => $prod->discount,
                'sold' => $prod->sold,
                'created_at' => $prod->createdAt,
                'updated_at' => $prod->createdAt,
            ]);
        }

        // 4. Copy Orders (Skipped)
        
        // 5. Copy Order Items (Skipped)
    }
}
