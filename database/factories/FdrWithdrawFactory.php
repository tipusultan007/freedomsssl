<?php

namespace Database\Factories;

use App\Models\FdrWithdraw;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class FdrWithdrawFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FdrWithdraw::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_no' => $this->faker->text(255),
            'date' => $this->faker->date,
            'withdraw_amount' => $this->faker->randomNumber(0),
            'note' => $this->faker->text(255),
            'balance' => $this->faker->randomNumber(0),
            'user_id' => \App\Models\User::factory(),
            'fdr_id' => \App\Models\Fdr::factory(),
            'fdr_deposit_id' => \App\Models\FdrDeposit::factory(),
            'created_by' => \App\Models\User::factory(),
        ];
    }
}
