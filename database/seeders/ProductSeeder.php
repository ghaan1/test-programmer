<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Helpers\General;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alatMusik = ProductCategory::where('name', 'Alat Musik')->first();
        $alatOlahraga = ProductCategory::where('name', 'Alat Olahraga')->first();

        $productCategories = [
            [
                'id' => "P" . General::generateId(),
                'name' => 'Jersey Liverpool',
                'fk_product_category' => $alatOlahraga->id,
                'price' => 1250000,
                'selling_price' => 1625000,
                'stock' => 120,
                'image' => 'images/jersey-liverpool.jpg',

            ],
            [
                'id' => "P" . General::generateId(),
                'name' => 'Dumbbell 5kg',
                'fk_product_category' => $alatOlahraga->id,
                'price' => 80000,
                'selling_price' => 1625000,
                'stock' => 120,
                'image' => 'images/dumbbell-5kg.jpg',
            ],
            [
                'id' => "P" . General::generateId(),
                'name' => 'Yoga Mat',
                'fk_product_category' => $alatOlahraga->id,
                'price' => 120000,
                'selling_price' => 156000,
                'stock' => 120,
                'image' => 'images/yoga-mat.jpg',
            ],
            [
                'id' => "P" . General::generateId(),
                'name' => 'Gitar Akustik',
                'fk_product_category' => $alatMusik->id,
                'price' => 1000000,
                'selling_price' => 1300000,
                'stock' => 120,
                'image' => 'images/gitar-akustik.jpg',
            ],
            [
                'id' => "P" . General::generateId(),
                'name' => 'Drum Set',
                'fk_product_category' => $alatMusik->id,
                'price' => 2200000,
                'selling_price' => 2860000,
                'stock' => 120,
                'image' => 'images/drum-set.jpg',
            ],
            [
                'id' => "P" . General::generateId(),
                'name' => 'Bola Basket',
                'fk_product_category' => $alatOlahraga->id,
                'price' => 60000,
                'selling_price' => 78000,
                'stock' => 120,
                'image' => 'images/bola-basket.jpg',
            ],
            [
                'id' => "P" . General::generateId(),
                'name' => 'Piano Elektrik',
                'fk_product_category' => $alatMusik->id,
                'price' => 3000000,
                'selling_price' => 3900000,
                'stock' => 120,
                'image' => 'images/piano-elektrik.jpg',
            ],
            [
                'id' => "P" . General::generateId(),
                'name' => 'Treadmill',
                'fk_product_category' => $alatOlahraga->id,
                'price' => 2000000,
                'selling_price' => 2600000,
                'stock' => 120,
                'image' => 'images/treadmill.jpg',
            ],
            [
                'id' => "P" . General::generateId(),
                'name' => 'Biola',
                'fk_product_category' => $alatMusik->id,
                'price' => 1400000,
                'selling_price' => 1820000,
                'stock' => 120,
                'image' => 'images/biola.jpg',
            ],
            [
                'id' => "P" . General::generateId(),
                'name' => 'Sepatu Lari',
                'fk_product_category' => $alatOlahraga->id,
                'price' => 200000,
                'selling_price' => 260000,
                'stock' => 120,
                'image' => 'images/sepatu-lari.jpg',
            ],
            [
                'id' => "P" . General::generateId(),
                'name' => 'Sepatu Lari',
                'fk_product_category' => $alatOlahraga->id,
                'price' => 200000,
                'selling_price' => 260000,
                'stock' => 120,
                'image' => 'images/sepatu-lari.jpg',
            ],
        ];

        foreach ($productCategories as $productCategory) {
            Product::create($productCategory);
        }
    }
}