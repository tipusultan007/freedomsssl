<?php

namespace Database\Factories;

use App\Models\DpsLoan;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class DpsLoanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DpsLoan::class;

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
