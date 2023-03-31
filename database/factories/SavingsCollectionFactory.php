<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\SavingsCollection;
use Illuminate\Database\Eloquent\Factories\Factory;

class SavingsCollectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SavingsCollection::class;

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
            'type' => $this->faker->text(255),
            'date' => $this->faker->date,
            'balance' => $this->faker->randomNumber(0),
            'daily_savings_id' => \App\Models\DailySavings::factory(),
            'user_id' => \App\Models\User::factory(),
            'collector_id' => \App\Models\User::factory(),
        ];
    }
}
