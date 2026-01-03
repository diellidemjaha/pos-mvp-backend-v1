<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1️⃣ Admin User
        |--------------------------------------------------------------------------
        */
        User::updateOrCreate(
            ['email' => 'admin@pos.test'],
            [
                'name' => 'POS Admin',
                'password' => Hash::make('password'),
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 2️⃣ Categories
        |--------------------------------------------------------------------------
        */
        $categoryNames = [
            'Drinks',
            'Food',
            'Snacks',
            'Desserts',
        ];

        foreach ($categoryNames as $name) {
            Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }

        $drinks   = Category::where('slug', 'drinks')->first();
        $food     = Category::where('slug', 'food')->first();
        $snacks   = Category::where('slug', 'snacks')->first();
        $desserts = Category::where('slug', 'desserts')->first();

        /*
        |--------------------------------------------------------------------------
        | 3️⃣ Products (linked to categories)
        |--------------------------------------------------------------------------
        */
        // Product::truncate(); // optional but recommended for dev

        Product::insert([
            // Drinks
            [
                'category_id' => $drinks->id,
                'sku' => 'P001',
                'name' => 'Coffee',
                'price' => 2.50,
                'stock' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $drinks->id,
                'sku' => 'P002',
                'name' => 'Tea',
                'price' => 2.00,
                'stock' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Food
            [
                'category_id' => $food->id,
                'sku' => 'P003',
                'name' => 'Chicken Sandwich',
                'price' => 4.50,
                'stock' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Snacks
            [
                'category_id' => $snacks->id,
                'sku' => 'P004',
                'name' => 'Potato Chips',
                'price' => 1.50,
                'stock' => 80,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Desserts
            [
                'category_id' => $desserts->id,
                'sku' => 'P005',
                'name' => 'Chocolate Cake',
                'price' => 3.00,
                'stock' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
