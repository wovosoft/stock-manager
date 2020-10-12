<?php

namespace Database\Factories;

use App\Models\CapitalWithdraw;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CapitalWithdrawFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CapitalWithdraw::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            "payment_amount" => $this->faker->randomFloat(2, 100, 1000000),
            "payment_method" => "Cash",
            "withdrawn_by" => 1,
            "created_at" => Carbon::now()->addDays(random_int(-30, 30))
        ];
    }
}
