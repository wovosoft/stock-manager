<?php

namespace Database\Factories;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;


class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $count_create=5;
        return [
            "name" => $this->faker->word,
            "barcode_symbology" => "code128",
            "code" => uniqid(),
            "cost" => $this->faker->randomFloat(2, 10, 500),
            "price" => $this->faker->randomFloat(2, 10, 500),
            "category_id" => random_int(1, $count_create),
            "subcategory_id" => random_int(1, $count_create),
            "brand_id" => random_int(1, $count_create),
            "status" => [true, false][random_int(0, 1)],
            "unit_id" => random_int(1, 4),
            "quantity" => random_int(1, 100),
            "alert_quantity" => random_int(1, 50),
            "description" => $this->faker->text(100),
            "created_at" => Carbon::now()->addDays(random_int(-30, 30))
        ];
    }
}

