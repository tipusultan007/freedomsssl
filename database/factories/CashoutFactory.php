<?php

namespace Database\Factories;

use App\Models\Cashout;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CashoutFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cashout::class;

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
            'description' => $this->faker->sentence(15),
            'date' => $this->faker->date,
            'cashout_category_id' => \App\Models\CashoutCategory::factory(),
            'created_by' => \App\Models\User::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
