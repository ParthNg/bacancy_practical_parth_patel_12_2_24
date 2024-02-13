<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Inventory;
use Carbon\Carbon;

class ProductAndInventorySeeder extends Seeder
{
    public function run()
    {
        // Seed products
        $product1 = Product::create([
            'name' => 'Product 1',
            'sku' => 'SKU123',
            'status' => 'active',
        ]);

        $product2 = Product::create([
            'name' => 'Product 2',
            'sku' => 'SKU456',
            'status' => 'active',
        ]);

        // Seed inventory for Product 1
        Inventory::create([
            'product_id' => $product1->id,
            'lot_name' => 'Lot 1',
            'quantity' => 100,
            'expiry_date' => Carbon::now()->addMonths(6)->toDateString(),
        ]);

        Inventory::create([
            'product_id' => $product1->id,
            'lot_name' => 'Lot 2',
            'quantity' => 50,
            'expiry_date' => Carbon::now()->addMonths(12)->toDateString(),
        ]);

        // Seed inventory for Product 2
        Inventory::create([
            'product_id' => $product2->id,
            'lot_name' => 'Lot 3',
            'quantity' => 75,
            'expiry_date' => Carbon::now()->addMonths(8)->toDateString(),
        ]);

    }
}

?>