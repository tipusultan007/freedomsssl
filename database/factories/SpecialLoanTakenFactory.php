<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\SpecialLoanTaken;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpecialLoanTakenFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SpecialLoanTaken::class;

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
            'before_loan' => $this->faker->randomNumber(0),
            'after_loan' => $this->faker->randomNumber(0),
            'interest1' => $this->faker->randomNumber(2),
            'interest2' => $this->faker->randomNumber(2),
            'upto_amount' => $this->faker->randomNumber(0),
            'date' => $this->faker->date,
            'commencement' => $this->faker->date,
            'installment' => $this->faker->randomNumber(0),
            'user_id' => \App\Models\User::factory(),
            'created_by' => \App\Models\User::factory(),
            'special_dps_loan_id' => \App\Models\SpecialDpsLoan::factory(),
        ];
    }
}
