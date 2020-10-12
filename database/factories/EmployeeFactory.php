<?php

namespace Database\Factories;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->name,
            "email" => $this->faker->companyEmail,
            "phone" => $this->faker->phoneNumber,
            "company" => $this->faker->company,
            "district" => $this->faker->word,
            "thana" => $this->faker->word,
            "post_office" => $this->faker->postcode,
            "village" => $this->faker->word,
            "joining_date" => $this->faker->date("Y-m-d"),
            "is_active" => true,
            "position" => $this->faker->jobTitle,
            "salary" => $this->faker->randomFloat(2, 10000, 50000),
            "created_at" => Carbon::now()->addDays(random_int(-30, 30))
        ];
    }
}
