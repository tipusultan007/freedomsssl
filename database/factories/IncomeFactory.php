<?php

namespace Database\Factories;

use App\Models\Income;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class IncomeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Income::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'amount' => $this->faker->randomNumber(2),
            'description' => $this->faker->text(255),
            'date' => $this->faker->date,
            'income_category_id' => \App\Models\IncomeCategory::factory(),
            'created_by' => \App\Models\User::factory(),
        ];
    }
}
