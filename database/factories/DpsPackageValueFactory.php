<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\DpsPackageValue;
use Illuminate\Database\Eloquent\Factories\Factory;

class DpsPackageValueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DpsPackageValue::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'year' => $this->faker->randomNumber(2),
            'amount' => $this->faker->randomNumber(0),
            'dps_package_id' => \App\Models\DpsPackage::factory(),
        ];
    }
}
