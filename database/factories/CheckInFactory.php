<?php


namespace Database\Factories;

use App\Models\CheckIn;
use Illuminate\Database\Eloquent\Factories\Factory;


class CheckInFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CheckIn::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "created_by" => 1,
            "datetime" => $this->faker->dateTimeBetween('-6 months', 'now'),
            "reference" => $this->faker->uuid,
            "supplier_id" => random_int(1, 20),
            "note" => $this->faker->text(120)
        ];
    }
}

