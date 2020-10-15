<?php

namespace Database\Factories;

use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;


class SaleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sale::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "customer_id" => random_int(1, 5),
            "total" => 0,
            "tax" => 0,
            "discount" => 0,
            "payable" => 0,
            "returned" => 0,
            "paid" => 0,
            "previous_balance" => 0,
            "current_balance" => 0,
            "date" => Carbon::now()->format("Y-m-d"),
            "status" => "Processed",
        ];
    }
}


