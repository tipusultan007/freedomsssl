<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ClosingAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClosingAccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClosingAccount::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_no' => $this->faker->text(255),
            'type' => $this->faker->text(255),
            'deposit' => $this->faker->randomNumber(0),
            'Withdraw' => $this->faker->randomNumber(0),
            'remain' => $this->faker->randomNumber(0),
            'profit' => $this->faker->randomNumber(0),
            'service_charge' => $this->faker->randomNumber(0),
            'total' => $this->faker->randomNumber(0),
            'date' => $this->faker->date,
            'user_id' => \App\Models\User::factory(),
            'created_by' => \App\Models\User::factory(),
            'daily_savings_id' => \App\Models\DailySavings::factory(),
            'dps_id' => \App\Models\Dps::factory(),
            'special_dps_id' => \App\Models\SpecialDps::factory(),
            'fdr_id' => \App\Models\Fdr::factory(),
        ];
    }
}
