<?php

namespace Database\Factories;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->name,
            "email" => $this->faker->email,
            "phone" => $this->faker->phoneNumber,
            "company" => $this->faker->company,
            "district" => $this->faker->word,
            "thana" => $this->faker->word,
            "post_office" => $this->faker->postcode,
            "village" => $this->faker->word,
            "shipping_address" => $this->faker->address,
            "created_at" => Carbon::now()->addDays(random_int(-30, 30))
        ];
    }
}
