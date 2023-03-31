<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\DailySavings;
use Illuminate\Database\Eloquent\Factories\Factory;

class DailySavingsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DailySavings::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_no' => $this->faker->text(20),
            'opening_date' => $this->faker->date,
            'status' => $this->faker->word,
            'user_id' => \App\Models\User::factory(),
            'introducer_id' => \App\Models\User::factory(),
            'created_by' => \App\Models\User::factory(),
        ];
    }
}
