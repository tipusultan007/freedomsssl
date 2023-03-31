<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\SpecialDpsLoan;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpecialDpsLoanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SpecialDpsLoan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_no' => $this->faker->text(255),
            'loan_amount' => $this->faker->randomNumber(0),
            'interest1' => $this->faker->randomNumber(2),
            'interest2' => $this->faker->randomNumber(2),
            'upto_amount' => $this->faker->randomNumber(0),
            'application_date' => $this->faker->date,
            'opening_date' => $this->faker->date,
            'commencement' => $this->faker->date,
            'status' => $this->faker->word,
            'total_paid' => $this->faker->randomNumber(0),
            'remain_loan' => $this->faker->randomNumber(0),
            'installment' => $this->faker->randomNumber(0),
            'user_id' => \App\Models\User::factory(),
            'approved_by' => \App\Models\User::factory(),
            'created_by' => \App\Models\User::factory(),
        ];
    }
}
