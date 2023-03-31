<?php

namespace Database\Factories;

use App\Models\SpecialDps;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpecialDpsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SpecialDps::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_no' => $this->faker->text(255),
            'balance' => $this->faker->randomNumber(0),
            'status' => $this->faker->word,
            'opening_date' => $this->faker->date,
            'user_id' => \App\Models\User::factory(),
            'special_dps_package_id' => \App\Models\SpecialDpsPackage::factory(),
            'created_by' => \App\Models\User::factory(),
        ];
    }
}
