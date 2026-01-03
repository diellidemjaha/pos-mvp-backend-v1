use App\Models\Product;
use App\Models\Category;

public function run(): void
{
    // Categories (safe)
    $drinks = Category::updateOrCreate(
        ['name' => 'Drinks'],
        ['created_at' => now()]
    );

    $food = Category::updateOrCreate(
        ['name' => 'Food'],
        ['created_at' => now()]
    );

    // Products (SKU-safe)
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
