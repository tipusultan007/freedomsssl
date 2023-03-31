<?php

namespace Database\Factories;

use App\Models\DailyLoan;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class DailyLoanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DailyLoan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'per_installment' => $this->faker->randomNumber(0),
            'opening_date' => $this->faker->date,
            'interest' => $this->faker->randomNumber(0),
            'adjusted_amount' => $this->faker->randomNumber(0),
            'commencement' => $this->faker->date,
            'loan_amount' => $this->faker->randomNumber(0),
            'application_date' => $this->faker->date,
            'status' => $this->faker->word,
            'package_id' => \App\Models\DailyLoanPackage::factory(),
            'user_id' => \App\Models\User::factory(),
            'created_by' => \App\Models\User::factory(),
            'approved_by' => \App\Models\User::factory(),
        ];
    }
}
