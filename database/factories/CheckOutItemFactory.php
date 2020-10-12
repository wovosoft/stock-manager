<?php

namespace Database\Factories;

use App\Models\CheckOutItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class CheckOutItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CheckOutItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
//        "check_in_id"=>random_int(1,20),
            "product_id" => random_int(1, 20),
            "quantity" => random_int(1, 5)
        ];
    }
}
