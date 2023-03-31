<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\DpsInstallment;
use Illuminate\Database\Eloquent\Factories\Factory;

class DpsInstallmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DpsInstallment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_no' => $this->faker->text(255),
            'dps_amount' => $this->faker->randomNumber(0),
            'dps_balance' => $this->faker->randomNumber(0),
            'receipt_no' => $this->faker->text(255),
            'late_fee' => $this->faker->randomNumber(0),
            'other_fee' => $this->faker->randomNumber(0),
            'grace' => $this->faker->randomNumber(0),
            'advance' => $this->faker->randomNumber(0),
            'loan_installment' => $this->faker->randomNumber(0),
            'interest' => $this->faker->randomNumber(0),
            'trx_id' => $this->faker->text(255),
            'loan_balance' => $this->faker->randomNumber(0),
            'total' => $this->faker->randomNumber(0),
            'due' => $this->faker->randomNumber(0),
            'due_return' => $this->faker->randomNumber(0),
            'date' => $this->faker->date,
            'user_id' => \App\Models\User::factory(),
            'dps_id' => \App\Models\Dps::factory(),
            'collector_id' => \App\Models\User::factory(),
            'dps_loan_id' => \App\Models\DpsLoan::factory(),
        ];
    }
}
