<?php

namespace Database\Factories;

use App\Models\Fdr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class FdrFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Fdr::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_no' => $this->faker->text(255),
            'duration' => $this->faker->randomNumber(2),
            'date' => $this->faker->date,
            'fdr_amount' => $this->faker->randomNumber(0),
            'deposit_date' => $this->faker->date,
            'commencement' => $this->faker->date,
            'note' => $this->faker->text(255),
            'user_id' => \App\Models\User::factory(),
            'fdr_package_id' => \App\Models\FdrPackage::factory(),
        ];
    }
}
