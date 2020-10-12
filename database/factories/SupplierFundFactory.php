<?php

namespace Database\Factories;

use App\Models\Supplier;
use App\Models\SupplierFund;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SupplierFundFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SupplierFund::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $type = ["deposit", "withdrawn"][random_int(0, 1)];
        $payment_amount = $this->faker->randomFloat(2, 100, 2000);
        $type_message = $type == 'deposit' ? 'Deposited' : 'Withdrawn';
        return [
            "payment_amount" => $payment_amount,
            "type" => $type,
            "message" => "BDT $payment_amount $type_message",
            "payment_method" => ["Cash", "Card", "Bank", "bKash", "Rocket", "Surecash", "Nagad"][random_int(0, 6)],
            "date" => Carbon::now()->subtract(-5, 5),
            "given_by" => 1
        ];
    }
}
