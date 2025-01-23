<?php

namespace Database\Seeders;

use App\Helpers\General;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productCategories = [
            [
                'id' => "PC" . General::generateId(),
                'name' => 'Alat Musik',
            ],
            [
                'id' => "PC" . General::generateId(),
                'name' => 'Alat Olahraga',
            ],
        ];

        foreach ($productCategories as $productCategory) {
            ProductCategory::create($productCategory);
        }
    }
}
