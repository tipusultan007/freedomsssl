<?php

namespace Database\Factories;

use App\Models\Nominees;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class NomineesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Nominees::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_no' => $this->faker->text(20),
            'name' => $this->faker->text(100),
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'relation' => $this->faker->text(20),
            'percentage' => $this->faker->randomNumber(0),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
