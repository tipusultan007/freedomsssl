<?php

namespace Database\Factories;

use App\Models\DpsPackage;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class DpsPackageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DpsPackage::class;

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
