<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\DailySavingsClosing;
use Illuminate\Database\Eloquent\Factories\Factory;

class DailySavingsClosingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DailySavingsClosing::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_no' => $this->faker->text(255),
            'total_deposit' => $this->faker->randomNumber(0),
            'total_withdraw' => $this->faker->randomNumber(0),
            'balance' => $this->faker->randomNumber(0),
            'interest' => $this->faker->randomNumber(0),
            'date' => $this->faker->date,
            'closing_fee' => $this->faker->randomNumber(0),
            'daily_savings_id' => \App\Models\DailySavings::factory(),
            'closing_by' => \App\Models\User::factory(),
        ];
    }
}
