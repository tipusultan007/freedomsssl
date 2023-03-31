<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\AdjustAmount;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdjustAmountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AdjustAmount::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'adjust_amount' => $this->faker->randomNumber(0),
            'before_adjust' => $this->faker->randomNumber(0),
            'after_adjust' => $this->faker->randomNumber(0),
            'date' => $this->faker->date,
            'daily_loan_id' => \App\Models\DailyLoan::factory(),
            'added_by' => \App\Models\User::factory(),
        ];
    }
}
