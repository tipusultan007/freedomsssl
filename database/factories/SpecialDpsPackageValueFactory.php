<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\SpecialDpsPackageValue;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpecialDpsPackageValueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SpecialDpsPackageValue::class;

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
            'special_dps_package_id' => \App\Models\SpecialDpsPackage::factory(),
        ];
    }
}
