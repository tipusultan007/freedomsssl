<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\DailyLoanCollection;
use Illuminate\Database\Eloquent\Factories\Factory;

class DailyLoanCollectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DailyLoanCollection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_no' => $this->faker->text(255),
            'loan_installment' => $this->faker->randomNumber(0),
            'loan_late_fee' => $this->faker->randomNumber(0),
            'loan_other_fee' => $this->faker->randomNumber(0),
            'loan_note' => $this->faker->text(255),
            'loan_balance' => $this->faker->randomNumber(0),
            'date' => $this->faker->date,
            'daily_loan_id' => \App\Models\DailyLoan::factory(),
            'collector_id' => \App\Models\User::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
