<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\DailyLoanPackage;
use Illuminate\Database\Eloquent\Factories\Factory;

class DailyLoanPackageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DailyLoanPackage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'months' => $this->faker->randomNumber(0),
            'interest' => $this->faker->randomNumber(2),
        ];
    }
}
