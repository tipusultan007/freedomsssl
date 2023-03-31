<?php

namespace Database\Factories;

use App\Models\Guarantor;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuarantorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Guarantor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'address' => $this->faker->text(255),
            'exist_ac_no' => $this->faker->text(255),
            'user_id' => \App\Models\User::factory(),
            'daily_loan_id' => \App\Models\DailyLoan::factory(),
        ];
    }
}
