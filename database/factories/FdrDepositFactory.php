<?php

namespace Database\Factories;

use App\Models\FdrDeposit;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class FdrDepositFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FdrDeposit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_no' => $this->faker->text(255),
            'amount' => $this->faker->randomNumber(0),
            'date' => $this->faker->date,
            'commencement' => $this->faker->date,
            'balance' => $this->faker->randomNumber(0),
            'profit' => $this->faker->randomNumber(0),
            'note' => $this->faker->text(255),
            'fdr_id' => \App\Models\Fdr::factory(),
            'user_id' => \App\Models\User::factory(),
            'fdr_package_id' => \App\Models\FdrPackage::factory(),
            'created_by' => \App\Models\User::factory(),
        ];
    }
}
