<?php

namespace Database\Factories;

use App\Models\AddProfit;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddProfitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AddProfit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_no' => $this->faker->text(255),
            'profit' => $this->faker->randomNumber(0),
            'before_profit' => $this->faker->randomNumber(0),
            'after_profit' => $this->faker->randomNumber(0),
            'date' => $this->faker->date,
            'duration' => $this->faker->text(255),
            'daily_savings_id' => \App\Models\DailySavings::factory(),
            'created_by' => \App\Models\User::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
