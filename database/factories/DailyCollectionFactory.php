<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\DailyCollection;
use Illuminate\Database\Eloquent\Factories\Factory;

class DailyCollectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DailyCollection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_no' => $this->faker->text(255),
            'saving_amount' => $this->faker->randomNumber(0),
            'saving_type' => $this->faker->text(255),
            'late_fee' => $this->faker->randomNumber(0),
            'other_fee' => $this->faker->randomNumber(0),
            'loan_installment' => $this->faker->randomNumber(0),
            'loan_late_fee' => $this->faker->randomNumber(0),
            'loan_other_fee' => $this->faker->randomNumber(0),
            'saving_note' => $this->faker->text(255),
            'loan_note' => $this->faker->text(255),
            'savings_balance' => $this->faker->randomNumber(0),
            'loan_balance' => $this->faker->randomNumber(0),
            'date' => $this->faker->date,
            'user_id' => \App\Models\User::factory(),
            'collector_id' => \App\Models\User::factory(),
            'daily_savings_id' => \App\Models\DailySavings::factory(),
            'daily_loan_id' => \App\Models\DailyLoan::factory(),
        ];
    }
}
