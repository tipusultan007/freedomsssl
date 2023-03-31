<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\CashoutCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class CashoutCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CashoutCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}
