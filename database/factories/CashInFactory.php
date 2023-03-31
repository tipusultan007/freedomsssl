<?php

namespace Database\Factories;

use App\Models\CashIn;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CashInFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CashIn::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_no' => $this->faker->text(255),
            'amount' => $this->faker->randomNumber(2),
            'trx_id' => $this->faker->text(255),
            'description' => $this->faker->text(255),
            'date' => $this->faker->date,
            'user_id' => \App\Models\User::factory(),
            'created_by' => \App\Models\User::factory(),
            'cashin_category_id' => \App\Models\CashinCategory::factory(),
        ];
    }
}
