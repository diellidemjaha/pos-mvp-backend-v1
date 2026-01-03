<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | ADMIN USER (SAFE FOR ALL ENVIRONMENTS)
        |--------------------------------------------------------------------------
        */
        User::updateOrCreate(
            ['email' => 'admin@pos.test'],
            [
                'name' => 'POS Admin',
                'password' => Hash::make(
                    env('ADMIN_PASSWORD', 'password')
                ),
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | ONLY SEED DEMO DATA LOCALLY
        |--------------------------------------------------------------------------
        */
        if (!app()->environment('local')) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */
        $drinks = Category::updateOrCreate(['name' => 'Drinks']);
        $food   = Category::updateOrCreate(['name' => 'Food']);

        /*
        |--------------------------------------------------------------------------
        | Products (SKU-safe)
        |--------------------------------------------------------------------------
        */
        Product::updateOrCreate(
            ['sku' => 'P001'],
            [
                'name' => 'Coffee',
                'price' => 2.50,
                'stock' => 100,
                'category_id' => $drinks->id,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'P002'],
            [
                'name' => 'Tea',
                'price' => 2.00,
                'stock' => 100,
                'category_id' => $drinks->id,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'P003'],
            [
                'name' => 'Chicken Sandwich',
                'price' => 4.50,
                'stock' => 50,
                'category_id' => $food->id,
            ]
        );
    }
}
