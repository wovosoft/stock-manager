<?php

namespace Database\Factories;

use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Brand::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->word,
            "description" => $this->faker->text(100),
            "created_at" => Carbon::now()->addDays(random_int(-30, 30))
        ];
    }
}
