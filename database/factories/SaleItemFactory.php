<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\SaleItem;
use Illuminate\Database\Eloquent\Factories\Factory;


class SaleItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SaleItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $quantity = random_int(1, 5);
        $product = Product::query()->findOrFail(random_int(1, 10));
        return [
            "product_id" => $product->id,
            "quantity" => $quantity,
            "price" => $product->price,
            "total" => $quantity * $product->price,
            "returned_quantity" => 0,
            "returned_total" => 0
        ];
    }
}

