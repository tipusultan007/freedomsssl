<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\SpecialDpsPackage;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpecialDpsPackageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SpecialDpsPackage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'amount' => $this->faker->randomNumber(0),
        ];
    }
}
