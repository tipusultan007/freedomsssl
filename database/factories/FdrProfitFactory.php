<?php

namespace Database\Factories;

use App\Models\FdrProfit;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class FdrProfitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FdrProfit::class;

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
            'balance' => $this->faker->randomNumber(0),
            'date' => $this->faker->date,
            'trx_id' => $this->faker->text(255),
            'month' => $this->faker->monthName,
            'year' => $this->faker->year,
            'note' => $this->faker->text(255),
            'user_id' => \App\Models\User::factory(),
            'fdr_id' => \App\Models\Fdr::factory(),
            'created_by' => \App\Models\User::factory(),
        ];
    }
}
