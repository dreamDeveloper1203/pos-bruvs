<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1, 20) as $index) {
            $name = $faker->word();
            $category = Category::create([
                'name' => $name,
                'sort_order' => $faker->randomNumber(1),
                'is_active' => $faker->boolean(75),
            ]);

            foreach (range(1, 10) as $index) {
                $product_name = $faker->word();
                $salePrice = $faker->randomFloat(0, 15000, 250000);
                Product::create([
                    'name' => $product_name,
                    'sort_order' => $faker->randomNumber(1),
                    'is_active' => $faker->boolean(75),
                    'sale_price' => $salePrice,
                    'discount_price' => 0,
                    'cost' => $faker->randomFloat(0, 10000, $salePrice),
                    'sku' => $faker->numberBetween(5, 10),
                    'description' => $faker->paragraph(),
                    'category_id' => $category->id,
                ]);
            }
        }
    }
}
