<?php

namespace Database\Factories;

use App\Models\CheckInItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class CheckInItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CheckInItem::class;

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
