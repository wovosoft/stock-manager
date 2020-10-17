<?php

namespace Database\Factories;

use App\Models\CapitalDeposit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CapitalDepositFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CapitalDeposit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "reference" => $this->faker->sentence,
            "payment_amount" => $this->faker->randomFloat(2, 100, 1000000),
            "payment_method" => "Cash",
            "deposited_by" => 1,
            "created_at" => Carbon::now()->addDays(random_int(-30, 30))
        ];
    }
}
