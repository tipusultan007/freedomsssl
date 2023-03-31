<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\FdrPackageValue;
use Illuminate\Database\Eloquent\Factories\Factory;

class FdrPackageValueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FdrPackageValue::class;

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
            'fdr_package_id' => \App\Models\FdrPackage::factory(),
        ];
    }
}
